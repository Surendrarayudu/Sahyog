<?php
/*
Copyright © 2009-2014 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

//set the path
$cmtx_path = '';

/* Database Connection */
require 'includes/db/connect.php'; //connect to database
if (!$cmtx_db_ok) { die(); }

//load function files
require_once $cmtx_path . 'includes/bootstrap/functions.php'; //load bootstrap file for functions

//load language files
require_once $cmtx_path . 'includes/bootstrap/language.php'; //load bootstrap file for language

if (!cmtx_setting('show_flag')) {
	die();
}

if (!cmtx_is_administrator()) { //if not administrator
	if (cmtx_in_maintenance()) { //check if under maintenance
		die();
	}
}

/* Error Reporting */
cmtx_error_reporting('includes/logs/errors.log');

/* Time Zone */
cmtx_set_time_zone(cmtx_setting('time_zone'));

$ip_address = cmtx_get_ip_address(); //get user's IP address

if (isset($_POST['id'])) {

	$id = $_POST['id'];
	$id = str_ireplace('cmtx_flag_', '', $id);
	if (!ctype_digit($id)) { die(); }
	$id = cmtx_sanitize($id, true, true);

	//check if comment exists
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$count = cmtx_db_num_rows($query);
	if ($count == 0) {
		echo CMTX_FLAG_NO_COMMENT;
		return;
	}

	//check if user is reporting own comment
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id' AND `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_FLAG_OWN_COMMENT;
		return;
	}

	//check if user is reporting admin comment
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id' AND `is_admin` = '1'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_FLAG_ADMIN_COMMENT;
		return;
	}

	//check if user is banned
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_FLAG_BANNED;
		return;
	}

	//check how many reports user has submitted
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "reporters` WHERE `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);

	if ($count >= cmtx_setting('flag_max_per_user')) {
		echo CMTX_FLAG_REPORT_LIMIT;
		return;
	}

	//check if user has already reported this comment
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "reporters` WHERE `ip_address` = '$ip_address' AND `comment_id` = '$id'");
	$count = cmtx_db_num_rows($query);

	if ($count > 0) {
		echo CMTX_FLAG_ALREADY_REPORTED;
		return;
	}

	//check if comment has already been flagged
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$result = cmtx_db_fetch_assoc($query);
	$count = $result["reports"];

	if ($count >= cmtx_setting('flag_min_per_comment')) {
		echo CMTX_FLAG_ALREADY_FLAGGED;
		return;
	}

	//check if comment has already been verified
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id' AND `is_verified` = '1'");
	$count = cmtx_db_num_rows($query);

	if ($count > 0) {
		echo CMTX_FLAG_ALREADY_VERIFIED;
		return;
	}
	

	//report comment

	echo CMTX_FLAG_REPORT_SENT;
	
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `reports` = `reports` + 1 WHERE `id` = '$id'");
	cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "reporters` (`comment_id`, `ip_address`, `dated`) values ('$id', '$ip_address', NOW())");

	//check if comment should be flagged
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$result = cmtx_db_fetch_assoc($query);
	$count = $result["reports"];

	if ($count == cmtx_setting('flag_min_per_comment')) {

		if (cmtx_setting('flag_disapprove')) {
			cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_approved` = '0' WHERE `id` = '$id'");
			cmtx_unapprove_replies($id);
		}

		//send email

		if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt')) {
			$admin_new_comment_flag_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_flag.txt'; //build path to custom admin new flag email file
		} else {
			$admin_new_comment_flag_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_flag.txt'; //build path to admin new flag email file
		}
		
		$body = file_get_contents($admin_new_comment_flag_email_file); //get the file's contents

		$comment_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
		$comment_result = cmtx_db_fetch_assoc($comment_query);

		$page_id = $comment_result['page_id'];

		$page_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$page_id'");
		$page_result = cmtx_db_fetch_assoc($page_query);

		$page_reference = cmtx_decode($page_result['reference']);
		$page_url = cmtx_decode($page_result['url']);
		$comment_url = cmtx_decode(cmtx_get_permalink($id, $page_result['url'])); //get the permalink of the comment
		$poster = cmtx_decode($comment_result['name']);
		$comment = cmtx_prepare_comment_for_email($comment_result['comment'], false);
		$admin_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url') . cmtx_setting('admin_folder')) . '/'; //build admin panel link

		//convert email variables with actual variables
		$body = str_ireplace('[page reference]', $page_reference, $body);
		$body = str_ireplace('[page url]', $page_url, $body);
		$body = str_ireplace('[comment url]', $comment_url, $body);
		$body = str_ireplace('[poster]', $poster, $body);
		$body = str_ireplace('[comment]', $comment, $body);
		$body = str_ireplace('[admin link]', $admin_link, $body);
		$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);

		//select administrators from database
		$admins = cmtx_db_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_flag` = '1' AND `is_enabled` = '1'");

		while ($admin = cmtx_db_fetch_assoc($admins)) { //while there are administrators

			$email = $admin['email']; //get administrator email address

			cmtx_email($email, null, cmtx_setting('admin_new_flag_subject'), $body, cmtx_setting('admin_new_flag_from_email'), cmtx_setting('admin_new_flag_from_name'), cmtx_setting('admin_new_flag_reply_to'));

		}

	}

}
?>