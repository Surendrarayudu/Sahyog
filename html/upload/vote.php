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

if (!cmtx_setting('show_like') && !cmtx_setting('show_dislike')) {
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

if (isset($_POST['id']) && isset($_POST['type'])) {

	$id = $_POST['id'];
	$id = str_ireplace('cmtx_like_', '', $id);
	$id = str_ireplace('cmtx_dislike_', '', $id);
	if (!ctype_digit($id)) { die(); }
	$id = cmtx_sanitize($id, true, true);
	
	$type = $_POST['type'];
	if ($type != 'like' && $type != 'dislike') { die(); }
	
	//check if comment exists
	$query = cmtx_db_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$count = cmtx_db_num_rows($query);
	if ($count == 0) {
		echo CMTX_VOTE_NO_COMMENT;
		return;
	}
	
	//check if user is voting own comment
	$query = cmtx_db_query("SELECT `ip_address` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id' and `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_VOTE_OWN_COMMENT;
		return;
	}

	//check if user has already voted
	$query = cmtx_db_query("SELECT `ip_address` FROM `" . $cmtx_mysql_table_prefix . "voters` WHERE `comment_id` = '$id' and `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_VOTE_ALREADY_VOTED;
		return;
	}
	
	//check if user is banned
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `ip_address` = '$ip_address'");
	$count = cmtx_db_num_rows($query);
	if ($count > 0) {
		echo CMTX_VOTE_BANNED;
		return;
	}

	if ($type == 'like' && cmtx_setting('show_like')) {

		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `likes` = `likes` + 1 WHERE `id` = '$id'");
		cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "voters` (`comment_id`, `ip_address`, `dated`) values ('$id', '$ip_address', NOW())");

	} else if ($type == 'dislike' && cmtx_setting('show_dislike')) {

		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `dislikes` = `dislikes` + 1 WHERE `id` = '$id'");
		cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "voters` (`comment_id`, `ip_address`, `dated`) values ('$id', '$ip_address', NOW())");

	}
	
	if ($type == 'like') {
	
		$result = cmtx_db_query("SELECT `likes` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
		if (cmtx_db_num_rows($result)) {
			$row = cmtx_db_fetch_assoc($result);
			$likes = $row['likes'];
		} else {
			$likes = 0;
		}
		
		echo '<img src="' . cmtx_commentics_url() . 'images/buttons/like.png" alt="Like" title="' . CMTX_TITLE_LIKE . '"/><span id="cmtx_flash_like_' . $id . '">' . $likes . '</span>';
	
	} else if ($type == 'dislike') {
	
		$result = cmtx_db_query("SELECT `dislikes` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
		if (cmtx_db_num_rows($result)) {
			$row = cmtx_db_fetch_assoc($result);
			$dislikes = $row['dislikes'];
		} else {
			$dislikes = 0;
		}
		
		echo '<img src="' . cmtx_commentics_url() . 'images/buttons/dislike.png" alt="Dislike" title="' . CMTX_TITLE_DISLIKE . '"/><span id="cmtx_flash_dislike_' . $id . '">' . $dislikes . '</span>';
		
	}

}
?>