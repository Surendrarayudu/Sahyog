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

if (!isset($cmtx_path)) { die('Access Denied.'); }

function cmtx_subscriber_exists($email, $page_id) { //check whether subscriber exists

	global $cmtx_mysql_table_prefix; //globalise variables

	$email = strtolower($email); //temporarily convert to lowercase

	//check whether a confirmed subscriber of current page
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `email` = '$email' AND `page_id` = '$page_id' AND `is_confirmed` = '1'"))) {
		return true;
	} else {
		return false;
	}

} //end of subscriber-exists function


function cmtx_subscriber_email_attempts($email) { //check whether email address has any unconfirmed subscriptions

	global $cmtx_mysql_table_prefix; //globalise variables

	$email = strtolower($email); //temporarily convert to lowercase

	//check whether email address has any unconfirmed subscriptions for any page
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `email` = '$email' AND `is_confirmed` = '0'"))) {
		return true;
	} else {
		return false;
	}

} //end of subscriber-email-attempts function


function cmtx_subscriber_ip_attempts() { //check whether IP address has any unconfirmed subscriptions

	global $cmtx_mysql_table_prefix; //globalise variables

	$ip_address = cmtx_get_ip_address();

	//check whether IP address has any unconfirmed subscriptions for any page
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `ip_address` = '$ip_address' AND `is_confirmed` = '0'"))) {
		return true;
	} else {
		return false;
	}

} //end of subscriber-ip-attempts function


function cmtx_add_subscriber($name, $email, $page_id) { //adds new subscriber

	global $cmtx_mysql_table_prefix, $cmtx_path; //globalise variables

	$ip_address = cmtx_get_ip_address();
	
	$is_unique = false; //initialise flag as false

	while (!$is_unique) { //while the token is not unique

		$token = cmtx_get_random_key(20); //create new token

		if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'")) == 0) { //if the token does not already exist
			$is_unique = true; //the created token is unique
		}

	}

	//insert subscriber into 'subscribers' database table
	cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "subscribers` (`name`, `email`, `page_id`, `token`, `to_all`, `to_admin`, `to_reply`, `is_confirmed`, `ip_address`, `dated`) VALUES ('$name', '$email', '$page_id', '$token', '1', '1', '1', '0', '$ip_address', NOW())");

	$name = cmtx_prepare_name_for_email($name); //prepare name for email
	$email = cmtx_prepare_email_for_email($email); //prepare email address for email

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt')) {
		$subscriber_confirmation_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_confirmation.txt'; //build path to custom subscriber confirmation email file
	} else {
		$subscriber_confirmation_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_confirmation.txt'; //build path to subscriber confirmation email file
	}
	
	$body = file_get_contents($subscriber_confirmation_email_file); //get the file's contents

	$confirmation_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url')) . "subscribers.php" . "?id=" . $token . "&confirm=1"; //build confirmation link

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page

	//convert email variables with actual variables
	$body = str_ireplace('[name]', $name, $body);
	$body = str_ireplace('[page reference]', $page_reference, $body);
	$body = str_ireplace('[page url]', $page_url, $body);
	$body = str_ireplace('[confirmation link]', $confirmation_link, $body);
	$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);

	//send email
	cmtx_email($email, $name, cmtx_setting('subscriber_confirmation_subject'), $body, cmtx_setting('subscriber_confirmation_from_email'), cmtx_setting('subscriber_confirmation_from_name'), cmtx_setting('subscriber_confirmation_reply_to'));
	
} //end of add-subscriber function


function cmtx_notify_subscribers($poster, $comment, $page_id, $comment_id, $reply_to, $is_admin) { //notify subscribers of new comment
	
	global $cmtx_parent_emails;
	
	$cmtx_parent_emails = array();

	function cmtx_get_parent_emails($reply_to) { //get email addresses of parent comments
	
		global $cmtx_mysql_table_prefix, $cmtx_parent_emails;
		
		$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$reply_to'");
		
		while ($comments = cmtx_db_fetch_assoc($query)) {
		
			$id = $comments['id'];
			$reply_to = $comments['reply_to'];
		
			$comment = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id' AND `is_approved` = '1'");
			$comment = cmtx_db_fetch_assoc($comment);
			array_push($cmtx_parent_emails, $comment['email']);
		
			cmtx_get_parent_emails($reply_to);
		
		}

	} //end of get-parent-emails function
	
	cmtx_get_parent_emails($reply_to);
	
	cmtx_notify_subscribers_reply($poster, $comment, $page_id, $comment_id);
	if ($is_admin) {
		cmtx_notify_subscribers_admin($poster, $comment, $page_id, $comment_id);
	} else {
		cmtx_notify_subscribers_basic($poster, $comment, $page_id, $comment_id);
	}

} //end of notify-subscribers function


function cmtx_notify_subscribers_basic($poster, $comment, $page_id, $comment_id) { //notify subscribers of basic comment

	global $cmtx_mysql_table_prefix, $cmtx_path, $cmtx_parent_emails; //globalise variables

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, cmtx_get_page_url())); //get the permalink of the comment

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt')) {
		$subscriber_notification_basic_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt'; //build path to custom subscriber notification basic email file
	} else {
		$subscriber_notification_basic_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_basic.txt'; //build path to subscriber notification basic email file
	}

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$count = 0; //count how many emails are sent

	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if ($subscriber['to_all']) {
	
			if (!in_array($subscriber['email'], $cmtx_parent_emails)) {

				$body = file_get_contents($subscriber_notification_basic_email_file); //get the file's contents

				$email = $subscriber['email'];

				$name = cmtx_decode($subscriber['name']);

				$token = $subscriber['token'];

				$subscription_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url')) . 'subscribers.php' . '?id=' . $token; //build subscription link

				//convert email variables with actual variables
				$body = str_ireplace('[name]', $name, $body);
				$body = str_ireplace('[page reference]', $page_reference, $body);
				$body = str_ireplace('[page url]', $page_url, $body);
				$body = str_ireplace('[comment url]', $comment_url, $body);
				$body = str_ireplace('[poster]', $poster, $body);
				$body = str_ireplace('[comment]', $comment, $body);
				$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);
				$body = str_ireplace('[subscription link]', $subscription_link, $body);

				//send email
				cmtx_email($email, $name, cmtx_setting('subscriber_notification_basic_subject'), $body, cmtx_setting('subscriber_notification_basic_from_email'), cmtx_setting('subscriber_notification_basic_from_name'), cmtx_setting('subscriber_notification_basic_reply_to'));

				$count++; //increment email counter
			
			}
		}
	}

	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' ORDER BY `dated` DESC LIMIT 1"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' ORDER BY `dated` DESC LIMIT 1"); //set how many were sent (if any)

} //end of notify-subscribers-basic function


function cmtx_notify_subscribers_reply($poster, $comment, $page_id, $comment_id) { //notify subscribers of reply

	global $cmtx_mysql_table_prefix, $cmtx_path, $cmtx_parent_emails; //globalise variables

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, cmtx_get_page_url())); //get the permalink of the comment

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt')) {
		$subscriber_notification_reply_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt'; //build path to custom subscriber notification reply email file
	} else {
		$subscriber_notification_reply_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_reply.txt'; //build path to subscriber notification reply email file
	}

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$count = 0; //count how many emails are sent

	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if ($subscriber['to_all'] || $subscriber['to_reply']) {
	
			if (in_array($subscriber['email'], $cmtx_parent_emails)) {

				$body = file_get_contents($subscriber_notification_reply_email_file); //get the file's contents

				$email = $subscriber['email'];

				$name = cmtx_decode($subscriber['name']);

				$token = $subscriber['token'];

				$subscription_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url')) . 'subscribers.php' . '?id=' . $token; //build subscription link

				//convert email variables with actual variables
				$body = str_ireplace('[name]', $name, $body);
				$body = str_ireplace('[page reference]', $page_reference, $body);
				$body = str_ireplace('[page url]', $page_url, $body);
				$body = str_ireplace('[comment url]', $comment_url, $body);
				$body = str_ireplace('[poster]', $poster, $body);
				$body = str_ireplace('[comment]', $comment, $body);
				$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);
				$body = str_ireplace('[subscription link]', $subscription_link, $body);

				//send email
				cmtx_email($email, $name, cmtx_setting('subscriber_notification_reply_subject'), $body, cmtx_setting('subscriber_notification_reply_from_email'), cmtx_setting('subscriber_notification_reply_from_name'), cmtx_setting('subscriber_notification_reply_reply_to'));

				$count++; //increment email counter
			
			}
		}
	}

	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' ORDER BY `dated` DESC LIMIT 1"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' ORDER BY `dated` DESC LIMIT 1"); //set how many were sent (if any)

} //end of notify-subscribers-reply function


function cmtx_notify_subscribers_admin($poster, $comment, $page_id, $comment_id) { //notify subscribers of admin comment

	global $cmtx_mysql_table_prefix, $cmtx_path, $cmtx_parent_emails; //globalise variables

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, cmtx_get_page_url())); //get the permalink of the comment

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt')) {
		$subscriber_notification_admin_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt'; //build path to custom subscriber notification admin email file
	} else {
		$subscriber_notification_admin_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_admin.txt'; //build path to subscriber notification admin email file
	}
	
	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$count = 0; //count how many emails are sent

	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if ($subscriber['to_all'] || $subscriber['to_admin']) {
	
			if (!in_array($subscriber["email"], $cmtx_parent_emails)) {

				$body = file_get_contents($subscriber_notification_admin_email_file); //get the file's contents

				$email = $subscriber['email'];

				$name = cmtx_decode($subscriber['name']);

				$token = $subscriber['token'];

				$subscription_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url')) . 'subscribers.php' . '?id=' . $token; //build subscription link

				//convert email variables with actual variables
				$body = str_ireplace('[name]', $name, $body);
				$body = str_ireplace('[page reference]', $page_reference, $body);
				$body = str_ireplace('[page url]', $page_url, $body);
				$body = str_ireplace('[comment url]', $comment_url, $body);
				$body = str_ireplace('[poster]', $poster, $body);
				$body = str_ireplace('[comment]', $comment, $body);
				$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);
				$body = str_ireplace('[subscription link]', $subscription_link, $body);

				//send email
				cmtx_email($email, $name, cmtx_setting('subscriber_notification_admin_subject'), $body, cmtx_setting('subscriber_notification_admin_from_email'), cmtx_setting('subscriber_notification_admin_from_name'), cmtx_setting('subscriber_notification_admin_reply_to'));

				$count++; //increment email counter
			
			}
		}
	}

	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' ORDER BY `dated` DESC LIMIT 1"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' ORDER BY `dated` DESC LIMIT 1"); //set how many were sent (if any)

} //end of notify-subscribers-admin function


function cmtx_notify_admin_new_ban($reason) { //notify admin of new ban

	global $cmtx_mysql_table_prefix, $cmtx_path; //globalise variables

	$ip_address = cmtx_get_ip_address();

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt')) {
		$admin_new_ban_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_ban.txt'; //build path to custom admin new ban email file
	} else {
		$admin_new_ban_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_ban.txt'; //build path to admin new ban email file
	}

	$body = file_get_contents($admin_new_ban_email_file); //get the file's contents

	$admin_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url') . cmtx_setting('admin_folder')) . '/'; //build admin panel link

	//convert email variables with actual variables
	$body = str_ireplace('[ip address]', $ip_address, $body);
	$body = str_ireplace('[ban reasoning]', $reason, $body);
	$body = str_ireplace('[admin link]', $admin_link, $body);
	$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);

	//select administrators from database
	$admins = cmtx_db_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_ban` = '1' AND `is_enabled` = '1'");

	while ($admin = cmtx_db_fetch_assoc($admins)) { //while there are administrators

		$email = $admin['email']; //get administrator email address
		
		cmtx_email($email, null, cmtx_setting('admin_new_ban_subject'), $body, cmtx_setting('admin_new_ban_from_email'), cmtx_setting('admin_new_ban_from_name'), cmtx_setting('admin_new_ban_reply_to'));

	}

} //end of notify-admin-new-ban function


function cmtx_notify_admin_new_comment_approve($poster, $comment, $comment_id) { //notify admin of new comment to approve

	global $cmtx_mysql_table_prefix, $cmtx_path, $cmtx_approve_reason; //globalise variables

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt')) {
		$admin_new_comment_approve_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_approve.txt'; //build path to custom admin new comment approve email file
	} else {
		$admin_new_comment_approve_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_approve.txt'; //build path to admin new comment approve email file
	}
	
	$body = file_get_contents($admin_new_comment_approve_email_file); //get the file's contents

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, cmtx_get_page_url())); //get the permalink of the comment

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$admin_link = cmtx_url_encode_spaces(cmtx_setting('commentics_url') . cmtx_setting('admin_folder')) . '/'; //build admin panel link

	//convert email variables with actual variables
	$body = str_ireplace('[page reference]', $page_reference, $body);
	$body = str_ireplace('[page url]', $page_url, $body);
	$body = str_ireplace('[comment url]', $comment_url, $body);
	$body = str_ireplace('[poster]', $poster, $body);
	$body = str_ireplace('[comment]', $comment, $body);
	$body = str_ireplace('[approval reasoning]', $cmtx_approve_reason, $body);
	$body = str_ireplace('[admin link]', $admin_link, $body);
	$body = str_ireplace('[signature]', cmtx_setting('signature'), $body);

	//select administrators from database
	$admins = cmtx_db_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_comment_approve` = '1' AND `is_enabled` = '1'");

	while ($admin = cmtx_db_fetch_assoc($admins)) { //while there are administrators

		$email = $admin['email']; //get administrator email address
		
		cmtx_email($email, null, cmtx_setting('admin_new_comment_approve_subject'), $body, cmtx_setting('admin_new_comment_approve_from_email'), cmtx_setting('admin_new_comment_approve_from_name'), cmtx_setting('admin_new_comment_approve_reply_to'));

	}

} //end of notify-admin-new-comment-approve function


function cmtx_notify_admin_new_comment_okay ($poster, $comment, $comment_id) { //notify admin of new comment

	global $cmtx_mysql_table_prefix, $cmtx_is_admin, $cmtx_path; //globalise variables

	if (file_exists($cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt')) {
		$admin_new_comment_okay_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/custom/new_comment_okay.txt'; //build path to custom admin new comment okay email file
	} else {
		$admin_new_comment_okay_email_file = $cmtx_path . 'includes/emails/' . cmtx_setting('language_frontend') . '/admin/new_comment_okay.txt'; //build path to admin new comment okay email file
	}
	
	$body = file_get_contents($admin_new_comment_okay_email_file); //get the file's contents

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, cmtx_get_page_url())); //get the permalink of the comment

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

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
	$admins = cmtx_db_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_comment_okay` = '1' AND `is_enabled` = '1'");

	while ($admin = cmtx_db_fetch_assoc($admins)) { //while there are administrators

		$email = $admin['email']; //get administrator email address

		if ($cmtx_is_admin && cmtx_is_admin_email($email)) {} else { //if not detected admin who submitted

			cmtx_email($email, null, cmtx_setting('admin_new_comment_okay_subject'), $body, cmtx_setting('admin_new_comment_okay_from_email'), cmtx_setting('admin_new_comment_okay_from_name'), cmtx_setting('admin_new_comment_okay_reply_to'));

		}

	}

} //end of notify-admin-new-comment-okay function


function cmtx_is_admin_email($email) { //checks whether email address belongs to detected admin

	global $cmtx_mysql_table_prefix; //globalise variables

	$is_admin_email = false; //initialise flag as false

	$ip_address = cmtx_get_ip_address();

	if (isset($_COOKIE['Commentics-Admin']) && ctype_alnum($_COOKIE['Commentics-Admin']) && cmtx_strlen($_COOKIE['Commentics-Admin']) == 20) {
		$cookie_value = cmtx_sanitize($_COOKIE['Commentics-Admin'], true, true);
	} else {
		$cookie_value = '';
	}

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1"))) {

		$admin = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1");
		$admin = cmtx_db_fetch_assoc($admin);

	} else {
	
		$admin = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1' LIMIT 1");
		$admin = cmtx_db_fetch_assoc($admin);

	}

	if ($email == $admin['email']) {
		$is_admin_email = true;
	}

	return $is_admin_email;

} //end of is-admin-email function


function cmtx_check_for_one_name($name) { //checks whether a single name was entered

	$number_of_names = count(explode(' ', $name)); //get number of names

	if ($number_of_names > 1) { //if more than one name
		cmtx_error(CMTX_ERROR_MESSAGE_ONE_NAME); //reject user for entering more than one name
	}

} //end of check-for-one-name function


function cmtx_validate_name($name) { //checks whether name was valid

	if (!preg_match('/^[\p{L}]+/u', $name)) { //if the submitted name does not start with a letter
		cmtx_error(CMTX_ERROR_MESSAGE_START_NAME); //reject user for not starting with a letter
	}
	
	if (!preg_match('/^[\p{L}&\-\'. 0-9]+$/u', $name)) { //if the submitted name contains invalid characters
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_NAME); //reject user for entering invalid characters
	}
	
	// letters, ampersand, hyphen, apostrophe, period, space, numbers
	// \p{L} (any kind of letter from any language)

} //end of validate-name function


function cmtx_check_for_word($file, $boundary, $entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks whether a specific word was entered

	global $cmtx_path; //globalise variables

	$word_found = false; //initialise flag as false

	if (file_exists($cmtx_path . 'includes/words/custom/' . $file . '.txt')) {
		$words_file = $cmtx_path . 'includes/words/custom/' . $file . '.txt'; //build path to custom words file
	} else {
		$words_file = $cmtx_path . 'includes/words/' . $file . '.txt'; //build path to words file
	}

	if (filesize($words_file) != 0) { //if file is not empty

		$words = file($words_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($words as $word) { //for each word

			$word = preg_quote($word, '/'); //escape any special characters

			$word = str_ireplace('\*', '[^ .,]*', $word); //allow use of wildcard symbol

			if ($boundary) {
				$regexp = "/\b$word\b/i"; //pattern (b = word boundary, i = case-insensitive)
			} else {
				$regexp = "/$word/i"; //pattern (i = case-insensitive)
			}


			if (preg_match($regexp, $entry)) { //if there is a match
				$word_found = true; //set flag as true
			}

			if ( ($action == 'mask' || $action == 'mask_approve') && (!isset($_POST['cmtx_preview']) && !isset($_POST['cmtx_prev'])) ) { //if entering the word should result in masking and not in preview mode
				$entry = preg_replace($regexp, cmtx_setting('swear_word_masking'), $entry); //mask words
			}

		} //end of for-each-word

		if ($word_found) { //if word was entered
			if ($action == 'approve' || $action == 'mask_approve') { //if entering the word should require approval
				cmtx_approve($approve_msg); //approve user for entering word
			} else if ($action == 'reject') { //if entering the word should be rejected
				cmtx_error($error_msg); //reject user for entering word
			} else if ($action == 'ban') { //if entering the word should result in a ban
				cmtx_ban($ban_msg); //ban user for entering word
			}
		} //end of if-word-was-entered

	} //end of if-file-not-empty

	return $entry; //return the (possibly masked) entry

} //end of check-for-word function


function cmtx_validate_email($email) { //checks whether email address was valid

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_EMAIL); //reject user for invalid email address	
	}

} //end of validate-email function


function cmtx_validate_website($website) { //checks whether website was valid

	if (!filter_var($website, FILTER_VALIDATE_URL)) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
		return;
	}
	
	$scheme = parse_url($website, PHP_URL_SCHEME); //get scheme
	
	if ($scheme != 'http' && $scheme != 'https') {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
		return;
	}
	
	$host = parse_url($website, PHP_URL_HOST); //get host
	
	if (empty($host)) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
		return;
	}

	if (cmtx_setting('validate_website_ping')) { //if website should be pinged

		$record = dns_get_record($host);
		
		if (!$record) {
			cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
			return;
		}
		
		if (extension_loaded('curl')) { //if cURL is available
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Commentics');
			curl_setopt($ch, CURLOPT_URL, $website);
			curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($http_code >= 200 && $http_code < 300) {
				//okay
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
				return;
			}
					
		}

	} //end of if-website-should-be-pinged

} //end of validate-website function


function cmtx_validate_town($town) { //checks whether town was valid

	if (!preg_match('/^[\p{L}]+/u', $town)) { //if the submitted town does not start with a letter
		cmtx_error(CMTX_ERROR_MESSAGE_START_TOWN); //reject user for not starting with a letter
	}
	
	if (!preg_match('/^[\p{L}&\-\'. ]+$/u', $town)) { //if the submitted town contains invalid characters
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_TOWN); //reject user for entering invalid characters
	}
	
	// letters, ampersand, hyphen, apostrophe, period, space
	// \p{L} (any kind of letter from any language)

} //end of validate-town function


function cmtx_validate_country($country) { //checks whether country was valid

	if (!preg_match('/^[\p{L}&\-\'. ]+$/u', $country) || !preg_match('/^[\p{L}]+/u', $country)) { //if the submitted country does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_COUNTRY); //reject user for submitting invalid country
	}

	// letters, ampersand, hyphen, apostrophe, period, space
	// \p{L} (any kind of letter from any language)

} //end of validate-country function


function cmtx_validate_rating($rating) { //checks whether rating was valid

	if (!preg_match('/[1-5]/', $rating)) { //if the submitted rating does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_RATING); //reject user for submitting invalid rating
	}

} //end of validate-rating function


function cmtx_delete_rating() { //delete guest rating if rated

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables
	
	$ip_address = cmtx_get_ip_address();

	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "ratings` WHERE `ip_address` = '$ip_address' AND `page_id` = '$cmtx_page_id'");

} //end of delete-rating function


function cmtx_validate_reply($reply_id, $page_id) { //checks whether reply was valid

	global $cmtx_mysql_table_prefix; //globalise variables

	$reply_id = cmtx_sanitize($reply_id, true, true); //sanitize reply

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$reply_id' AND `page_id` = '$page_id' AND `is_approved` = '1'")) != 1 && $reply_id != 0) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_REPLY); //reject user for submitting invalid reply
	}

} //end of validate_reply function


function cmtx_comment_minimum($comment) { //checks whether comment is less than minimum settings

	$comment = str_ireplace('<br />', ' ', $comment); //remove <br /> tags
	$comment = str_ireplace('<p></p>', ' ', $comment); //remove <p></p> tags
	$comment = html_entity_decode($comment); //decode HTML entities
	$comment = strip_tags($comment); //strip any tags from comment
	$comment = trim($comment); //remove any space at beginning and end of comment

	$comment_number_of_characters = cmtx_strlen($comment); //number of characters in comment

	$comment_number_of_words = count(explode(' ', $comment)); //number of words in comment

	if ($comment_number_of_characters < cmtx_setting('comment_minimum_characters') || $comment_number_of_words < cmtx_setting('comment_minimum_words')) { //if comment is less than minimum
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MIN); //reject user for entering short comment
	}

} //end of comment-minimum function


function cmtx_comment_maximum($comment) { //checks whether comment exceeds maximum

	$comment = trim($comment); //remove any space at beginning and end of comment
	
	$comment = html_entity_decode($comment); //decode HTML entities

	$comment = strip_tags($comment); //strip any tags from comment

	$comment_number_of_characters = cmtx_strlen($comment); //number of characters in comment

	if ($comment_number_of_characters > cmtx_setting('comment_maximum_characters')) { //if comment exceeds maximum
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MAX); //reject user for entering long comment
	}

} //end of comment-maximum function


function cmtx_comment_max_lines($comment) { //checks whether comment contains too many lines

	$comment_number_of_lines = substr_count($comment, '<br />') + (substr_count($comment, '<p></p>') * 2); //number of lines in comment

	if ($comment_number_of_lines > cmtx_setting('comment_maximum_lines')) { //if comment contains too many lines
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES); //reject user for entering too many lines
	}

} //end of comment-max-lines function


function cmtx_comment_resubmit() { //checks whether comment is new

	if (cmtx_session_set() && isset($_SESSION['cmtx_resubmit_key'])) {

		if ($_SESSION['cmtx_resubmit_key'] == $_POST['cmtx_resubmit_key']) {
			cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT);
		}

	}

} //end of comment-resubmit function


function cmtx_check_repeats($entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks entry for repeating characters

	$repeats_found = false; //initialise flag as false

	if (cmtx_is_encoding_iso($entry)) { //if encoding is ISO-8859-1
		if (preg_match('/([^\d])\1{2,}/i', $entry)) { //if the submitted entry contains repeats
			$repeats_found = true;
		}
	}

	//3 or more non-numeric characters

	if ($repeats_found) { //if repeats found
		if ($action == 'approve') { //if entering repeats should require approval
			cmtx_approve($approve_msg); //approve user for entering repeats
		} else if ($action == 'reject') { //if entering repeats should be rejected
			cmtx_error($error_msg); //reject user for entering repeats
		} else if ($action == 'ban') { //if entering repeats should result in a ban
			cmtx_ban($ban_msg); //ban user for entering repeats
		}
	} //end of if-repeats-found

} //end of check-repeats function


function cmtx_check_for_link($entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks entry for link

	global $cmtx_path; //globalise variables

	$link_found = false; //initialise flag as false

	if (file_exists($cmtx_path . 'includes/words/custom/detect_links.txt')) {
		$detect_link_file = $cmtx_path . 'includes/words/custom/detect_links.txt'; //build path to custom link detection file
	} else {
		$detect_link_file = $cmtx_path . 'includes/words/detect_links.txt'; //build path to link detection file
	}

	if (filesize($detect_link_file) != 0) { //if file is not empty

		$link_detections = file($detect_link_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($link_detections as $link_detection) { //for each link detection

			$link_detection = preg_quote($link_detection, '/'); //escape any special characters

			$regexp = "/$link_detection/i"; //link detection pattern (i = case-insensitive)

			if (preg_match($regexp, $entry)) { //if there is a match
				$link_found = true; //set flag as true
			}

		} //end of for-each-link-detection

		if ($link_found) { //if link was entered
			if ($action == 'approve') { //if entering a link should require approval
				cmtx_approve($approve_msg); //approve user for entering link
			} else if ($action == 'reject') { //if entering a link should be rejected
				cmtx_error($error_msg); //reject user for entering link
			} else if ($action == 'ban') { //if entering a link should result in a ban
				cmtx_ban($ban_msg); //ban user for entering link
			}
		} //end of if-link-was-entered		

	} //end of if-file-not-empty

} //end of check-for-link function


function cmtx_comment_detect_image($comment) { //checks comment for images

	$image_found = stripos($comment, CMTX_BB_CODE_TAG_IMAGE_1); //check for image tag
	
	if ($image_found !== false) { //if image was entered
		cmtx_approve(CMTX_APPROVE_REASON_IMAGE_ENTERED); //approve user for entering image
	} //end of if-image-was-entered

} //end of comment-detect-image function


function cmtx_comment_detect_video($comment) { //checks comment for videos

	$video_found = stripos($comment, CMTX_BB_CODE_TAG_VIDEO_1); //check for video tag

	if ($video_found !== false) { //if video was entered
		cmtx_approve(CMTX_APPROVE_REASON_VIDEO_ENTERED); //approve user for entering video
	} //end of if-video-was-entered

} //end of comment-detect-video function


function cmtx_comment_add_bb_code($comment) { //add BB Code to comment

	$code_box_styling = 'background-color:#FAFAFA; width:500px; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$php_box_styling = 'background-color:#FAFAFA; width:500px; font-size:medium; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$quote_box_styling = 'background-color:#FAFAFA; width:500px; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$line_styling = 'color:#EDEDED;';

	if (cmtx_setting('enabled_bb_code_bold')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_BOLD_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_BOLD_2, '/') . '/is', '', $comment); //remove bold tags with nothing visible inside
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_BOLD_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_BOLD_2, '/') . '/is', '<b>$1</b>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_italic')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_ITALIC_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_ITALIC_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_ITALIC_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_ITALIC_2, '/') . '/is', '<i>$1</i>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_underline')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_UNDERLINE_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_UNDERLINE_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_UNDERLINE_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_UNDERLINE_2, '/') . '/is', '<u>$1</u>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_strike')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_STRIKE_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_STRIKE_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_STRIKE_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_STRIKE_2, '/') . '/is', '<del>$1</del>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_superscript')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_SUPERSCRIPT_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_SUPERSCRIPT_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_SUPERSCRIPT_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_SUPERSCRIPT_2, '/') . '/is', '<sup>$1</sup>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_subscript')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_SUBSCRIPT_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_SUBSCRIPT_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_SUBSCRIPT_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_SUBSCRIPT_2, '/') . '/is', '<sub>$1</sub>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_code')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_CODE_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_CODE_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_CODE_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_CODE_2, '/') . '/is', '<div style="' . $code_box_styling . '">$1</div>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_php')) {
		$comment = preg_replace('/\[PHP\]\s*\[\/PHP\]/is', '', $comment);
		while (preg_match('/\[PHP\](.*?)\[\/PHP\]/is', $comment, $matches)) {
			$code = html_entity_decode($matches[1], ENT_QUOTES);
			$code = trim($code);
			$code = highlight_string($code, true);
			$code = str_ireplace("\r", '', $code);
			$code = str_ireplace("\n", '', $code);
			$code = str_ireplace('&nbsp;', ' ', $code);
			$comment = str_ireplace('[PHP]' . $matches[1] . '[/PHP]', '<div style="' . $php_box_styling . '">' . $code . '</div>', $comment);
		}
	}

	if (cmtx_setting('enabled_bb_code_quote')) {
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_QUOTE_1, '/') . '\s*' . preg_quote(CMTX_BB_CODE_TAG_QUOTE_2, '/') . '/is', '', $comment);
		$comment = preg_replace('/' . preg_quote(CMTX_BB_CODE_TAG_QUOTE_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_QUOTE_2, '/') . '/is', '<div style="' . $quote_box_styling . '">$1</div>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_line')) {
		$comment = str_ireplace(CMTX_BB_CODE_TAG_LINE, '<hr style="' . $line_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_bullet')) {
		$comment = str_ireplace(CMTX_BB_CODE_TAG_BULLET_1 . "\r\n", '<ul>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_ITEM_1, '<li>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_ITEM_2 . "\r\n", '</li>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_BULLET_2, '</ul>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_numeric')) {
		$comment = str_ireplace(CMTX_BB_CODE_TAG_NUMERIC_1 . "\r\n", '<ol>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_ITEM_1, '<li>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_ITEM_2 . "\r\n", '</li>', $comment);
		$comment = str_ireplace(CMTX_BB_CODE_TAG_NUMERIC_2, '</ol>', $comment);
	}

	if (cmtx_setting('enabled_bb_code_link')) {

		global $cmtx_bb_code_link_attribute;

		$cmtx_bb_code_link_attribute = ''; //initialize variable

		if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
			$cmtx_bb_code_link_attribute = ' target="_blank"';
		}

		if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
			$cmtx_bb_code_link_attribute .= ' rel="nofollow"';
		}

		function cmtx_link_1(array $matches) {

			global $cmtx_bb_code_link_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return '<a href="' . $matches[1] . '"' . $cmtx_bb_code_link_attribute . '>' . $matches[1] . '</a>';
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_LINK);
				return;
			}
		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_LINK_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_LINK_4, '/') . '/is', 'cmtx_link_1', $comment);

		function cmtx_link_2(array $matches) {

			global $cmtx_bb_code_link_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);
			
			$matches[2] = trim($matches[2]);
			
			if (empty($matches[2])) {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_LINK);
				return;
			}

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return '<a href="' . $matches[1] . '"' . $cmtx_bb_code_link_attribute . '>' . $matches[2] . '</a>';
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_LINK);
				return;
			}
		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_LINK_2, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_LINK_3, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_LINK_4, '/') . '/is', 'cmtx_link_2', $comment);

	}

	if (cmtx_setting('enabled_bb_code_email')) {

		global $cmtx_bb_code_email_attribute;

		$cmtx_bb_code_email_attribute = ''; //initialize variable

		if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
			$cmtx_bb_code_email_attribute = ' target="_blank"';
		}

		if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
			$cmtx_bb_code_email_attribute .= ' rel="nofollow"';
		}

		function cmtx_email_1(array $matches) {

			global $cmtx_bb_code_email_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
				return '<a href="mailto:' . $matches[1] . '"' . $cmtx_bb_code_email_attribute . '>' . $matches[1] . '</a>';
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL);
				return;
			}
		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_EMAIL_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_EMAIL_4, '/') . '/is', 'cmtx_email_1', $comment);

		function cmtx_email_2(array $matches) {

			global $cmtx_bb_code_email_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);
			
			$matches[2] = trim($matches[2]);
			
			if (empty($matches[2])) {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL);
				return;
			}

			if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
				return '<a href="mailto:' . $matches[1] . '"' . $cmtx_bb_code_email_attribute . '>' . $matches[2] . '</a>';
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL);
				return;
			}
		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_EMAIL_2, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_EMAIL_3, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_EMAIL_4, '/') . '/is', 'cmtx_email_2', $comment);

	}

	if (cmtx_setting('enabled_bb_code_image')) {

		function cmtx_image_1(array $matches) {

			$image_styling = 'max-width:508px; height:auto;';

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return '<img src="' . $matches[1] . '" style="' . $image_styling . '"/>';
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE);
				return;
			}

		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_IMAGE_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_IMAGE_2, '/') . '/is', 'cmtx_image_1', $comment);

	}

	if (cmtx_setting('enabled_bb_code_video')) {

		function cmtx_video_1(array $matches) {

			global $cmtx_path;

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				require_once $cmtx_path . 'includes/external/AutoEmbed/AutoEmbed.class.php';
				$AE = new AutoEmbed();
				if (!$AE->parseUrl($matches[1])) {
					cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO);
					return;
				}
				return $AE->getEmbedCode();
			} else {
				cmtx_error(CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO);
				return;
			}
		}

		$comment = preg_replace_callback('/' . preg_quote(CMTX_BB_CODE_TAG_VIDEO_1, '/') . '(.*?)' . preg_quote(CMTX_BB_CODE_TAG_VIDEO_2, '/') . '/is', 'cmtx_video_1', $comment);

	}

	return $comment;

} //end of comment-add-bb-code function


function cmtx_comment_add_smilies($comment) { //add smilies to comment

	$smiley_styling = 'border-style: none; vertical-align: bottom;';

	if (cmtx_setting('enabled_smilies_smile')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_SMILE, '<img src="' . cmtx_commentics_url() . 'images/smilies/smile.gif" title="' . CMTX_SMILEY_TITLE_SMILE . '" alt="Smile" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_sad')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_SAD, '<img src="' . cmtx_commentics_url() . 'images/smilies/sad.gif" title="' . CMTX_SMILEY_TITLE_SAD . '" alt="Sad" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_huh')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_HUH, '<img src="' . cmtx_commentics_url() . 'images/smilies/huh.gif" title="' . CMTX_SMILEY_TITLE_HUH . '" alt="Huh" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_laugh')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_LAUGH, '<img src="' . cmtx_commentics_url() . 'images/smilies/laugh.gif" title="' . CMTX_SMILEY_TITLE_LAUGH . '" alt="Laugh" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_mad')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_MAD, '<img src="' . cmtx_commentics_url() . 'images/smilies/mad.gif" title="' . CMTX_SMILEY_TITLE_MAD . '" alt="Mad" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_tongue')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_TONGUE, '<img src="' . cmtx_commentics_url() . 'images/smilies/tongue.gif" title="' . CMTX_SMILEY_TITLE_TONGUE . '" alt="Tongue" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_crying')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_CRYING, '<img src="' . cmtx_commentics_url() . 'images/smilies/crying.gif" title="' . CMTX_SMILEY_TITLE_CRYING . '" alt="Crying" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_grin')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_GRIN, '<img src="' . cmtx_commentics_url() . 'images/smilies/grin.gif" title="' . CMTX_SMILEY_TITLE_GRIN . '" alt="Grin" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_wink')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_WINK, '<img src="' . cmtx_commentics_url() . 'images/smilies/wink.gif" title="' . CMTX_SMILEY_TITLE_WINK . '" alt="Wink" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_scared')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_SCARED, '<img src="' . cmtx_commentics_url() . 'images/smilies/scared.gif" title="' . CMTX_SMILEY_TITLE_SCARED . '" alt="Scared" style="' . $smiley_styling . '"/>', $comment);
	}	

	if (cmtx_setting('enabled_smilies_cool')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_COOL, '<img src="' . cmtx_commentics_url() . 'images/smilies/cool.gif" title="' . CMTX_SMILEY_TITLE_COOL . '" alt="Cool" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_sleep')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_SLEEP, '<img src="' . cmtx_commentics_url() . 'images/smilies/sleep.gif" title="' . CMTX_SMILEY_TITLE_SLEEP . '" alt="Sleep" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_blush')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_BLUSH, '<img src="' . cmtx_commentics_url() . 'images/smilies/blush.gif" title="' . CMTX_SMILEY_TITLE_BLUSH . '" alt="Blush" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_unsure')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_UNSURE, '<img src="' . cmtx_commentics_url() . 'images/smilies/unsure.gif" title="' . CMTX_SMILEY_TITLE_UNSURE . '" alt="Unsure" style="' . $smiley_styling . '"/>', $comment);
	}

	if (cmtx_setting('enabled_smilies_shocked')) {
		$comment = str_ireplace(CMTX_SMILEY_TAG_SHOCKED, '<img src="' . cmtx_commentics_url() . 'images/smilies/shocked.gif" title="' . CMTX_SMILEY_TITLE_SHOCKED . '" alt="Shocked" style="' . $smiley_styling . '"/>', $comment);
	}

	return $comment;

} //end of comment-add-smilies function


function cmtx_check_maximum_smilies($comment) { //checks whether number of smilies exceeds maximum

	$number_of_smilies = substr_count($comment, '<img src='); //number of smilies in comment

	if ($number_of_smilies > cmtx_setting('comment_maximum_smilies')) { //if number of smilies exceeds maximum
		cmtx_error(sprintf(CMTX_ERROR_MESSAGE_SMILIES_MAX, cmtx_setting('comment_maximum_smilies'))); //reject user for entering too many smilies
	}

} //end of check-maximum-smilies function


function cmtx_set_form_cookie($name, $email, $website, $town, $country) { //save user form inputs in cookie

	$name = cmtx_strip_slashes(cmtx_decode($name));
	$email = cmtx_strip_slashes(cmtx_decode($email));
	$website = cmtx_strip_slashes(cmtx_decode($website));
	$town = cmtx_strip_slashes(cmtx_decode($town));
	$country = cmtx_strip_slashes(cmtx_decode($country));
	
	$value = $name . '|' . $email . '|' . $website . '|' . $town . '|' . $country;
	
	?><script type="text/javascript">
	// <![CDATA[
	jQuery.cookie('Commentics-Form', "<?php echo $value; ?>", { expires: <?php echo cmtx_setting('form_cookie_days'); ?>, path: '/' });
	// ]]>
	</script><?php

} //end of set-form-cookie function


function cmtx_purify($comment) { //purifies HTML

	global $cmtx_path; //globalise variables

	if (!function_exists('htmLawed')) {
		require_once $cmtx_path . 'includes/external/htmLawed/htmLawed.php'; //load htmLawed script
	}

	$comment = htmLawed($comment); //purify

	return $comment;

} //end of purify function


function cmtx_akismet($name, $email, $website, $comment) { //check Akismet test for spam

	global $cmtx_path; //globalise variables

	$name = cmtx_strip_slashes(cmtx_decode($name));
	$email = cmtx_strip_slashes(cmtx_decode($email));
	$website = cmtx_strip_slashes(cmtx_decode($website));
	if ($website == 'http://') { $website = ''; }
	$comment = cmtx_strip_slashes(cmtx_decode($comment));

	if (!class_exists('Akismet')) {
		require_once $cmtx_path . 'includes/external/akismet/akismet.php'; //load Akismet script
	}

	$WordPressAPIKey = cmtx_setting('akismet_key'); //set API key

	$MyBlogURL = cmtx_setting('site_url');

	$akismet = new Akismet($MyBlogURL, $WordPressAPIKey);

	$akismet->setCommentAuthor($name);
	$akismet->setCommentAuthorEmail($email);
	$akismet->setCommentAuthorURL($website);
	$akismet->setCommentContent($comment);
	$akismet->setCommentType('comment');
	$akismet->setPermalink(cmtx_current_page());

	if ($akismet->isCommentSpam()) {
		return true;
	} else {
		return false;
	}

} //end of akismet function


function cmtx_repopulate() { //repopulate the form with posted data

	global $cmtx_default_name, $cmtx_default_email, $cmtx_default_website, $cmtx_default_town, $cmtx_default_country, $cmtx_default_rating, $cmtx_default_comment, $cmtx_reply_id, $cmtx_default_notify, $cmtx_default_remember, $cmtx_default_privacy, $cmtx_default_terms; //globalise variables

	if (isset($_POST['cmtx_name'])) { $cmtx_default_name = $_POST['cmtx_name']; }
	if (isset($_POST['cmtx_email'])) { $cmtx_default_email = $_POST['cmtx_email']; }
	if (isset($_POST['cmtx_website'])) { $cmtx_default_website = $_POST['cmtx_website']; }
	if (isset($_POST['cmtx_town'])) { $cmtx_default_town = $_POST['cmtx_town']; }
	if (isset($_POST['cmtx_country'])) { $cmtx_default_country = $_POST['cmtx_country']; }
	if (isset($_POST['cmtx_rating'])) { $cmtx_default_rating = $_POST['cmtx_rating']; }
	if (isset($_POST['cmtx_comment'])) { $cmtx_default_comment = $_POST['cmtx_comment']; }
	if (isset($_POST['cmtx_reply_id'])) { $cmtx_reply_id = $_POST['cmtx_reply_id']; }
	if (isset($_POST['cmtx_notify'])) { $cmtx_default_notify = true; } else { $cmtx_default_notify = false; }
	if (isset($_POST['cmtx_remember'])) { $cmtx_default_remember = true; } else { $cmtx_default_remember = false; }
	if (isset($_POST['cmtx_privacy'])) { $cmtx_default_privacy = true; }
	if (isset($_POST['cmtx_terms'])) { $cmtx_default_terms = true; }

} //end of repopulate function


function cmtx_get_name($id) { //get name from comment ID

	global $cmtx_mysql_table_prefix;

	$name_query = cmtx_db_query("SELECT `name` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$name_result = cmtx_db_fetch_assoc($name_query);
	$name = $name_result['name'];

	return $name;
	
} //end of get-name function


function cmtx_check_maximums() { //check field data does not exceed maximum lengths

	$pass = true;

	if (isset($_POST['cmtx_name'])) { //if name submitted
		if (cmtx_strlen($_POST['cmtx_name']) > cmtx_setting('field_maximum_name')) { //if name length exceeds maximum name length
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_email'])) {
		if (cmtx_strlen($_POST['cmtx_email']) > cmtx_setting('field_maximum_email')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_website'])) {
		if (cmtx_strlen($_POST['cmtx_website']) > cmtx_setting('field_maximum_website')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_town'])) {
		if (cmtx_strlen($_POST['cmtx_town']) > cmtx_setting('field_maximum_town')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_country'])) {
		if (cmtx_strlen($_POST['cmtx_country']) > 50) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_rating'])) {
		if (cmtx_strlen($_POST['cmtx_rating']) > 1) {
			$pass = false;
		}
	}

	if (!$pass) {
		cmtx_error(CMTX_ERROR_MESSAGE_MAXIMUMS);
	}

} //end of check-maximums function


function cmtx_fix_entry($entry) { //converts words to lowercase except first letter

	if (cmtx_is_encoding_iso($entry)) { //if encoding is ISO-8859-1
		$entry = ucwords(strtolower($entry)); //convert
	}

	return $entry; //return fixed entry

} //end of fix-entry function


function cmtx_is_encoding_iso($entry) { //checks whether character encoding is ISO-8859-1

	if (function_exists('mb_check_encoding') && is_callable('mb_check_encoding')) {
		if (mb_check_encoding($entry, 'ASCII')) {
			return true;
		} else {
			return false;
		}
	} else {
		if (preg_match('/^[\\x00-\\xFF]*$/u', $entry) === 1) {
			return true;
		} else {
			return false;
		}
	}

} //end of is-encoding-iso function


function cmtx_is_injected($entry) { //checks if entry contains injection attempt

	$injections = array('(\n+)','(\r+)','(\t+)','(%0A+)','(%0D+)','(%08+)','(%09+)');
	$inject = join('|', $injections);
	$inject = "/$inject/i";

	if (preg_match($inject,$entry)) { //if injection found
		cmtx_ban(CMTX_BAN_REASON_INJECTION); //ban user for injection attempt
	}

} //end of is-injected function


function cmtx_comment_parse_links($comment) { //convert plain text links to html

	$attribute = ''; //initialize variable

	if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
		$attribute = ' target="_blank"';
	}

	if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
		$attribute .= ' rel="nofollow"';
	}

	if (cmtx_setting('comment_parser_convert_links')) { //if web links should be converted
		$comment= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\"$attribute>$3</a>", $comment);
		$comment= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\"$attribute>$3</a>", $comment);
	}

	if (cmtx_setting('comment_parser_convert_emails')) { //if email addresses should be converted
		$comment= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\"$attribute>$2@$3</a>", $comment);
	}

	return $comment; //return parsed string

} //end of comment-parse-links function


function cmtx_comment_add_breaks($comment) { //add line breaks

	$comment = trim($comment);

	$comment = preg_replace("/(\r\n){2,}/", '<p></p>', $comment); //replace instances of 2 or more \r\n with <p></p>

	$comment = preg_replace('/(\<br \/\>){2,}/', '<p></p>', $comment); //replace instances of 2 or more <br />s with  <p></p>

	$comment = str_ireplace("\r\n", '<br />', $comment); //replace remaining line breaks with <br />s

	return $comment; //return breaked string

} //end of comment-add-breaks function


function cmtx_comment_remove_breaks($comment) { //remove line breaks

	$comment = trim($comment);

	$comment = preg_replace("/(\r\n){2,}/", ' ', $comment); //replace instances of 2 or more \r\n with a space

	$comment = str_ireplace("\r\n", ' ', $comment); //replace remaining line breaks with a space

	return $comment; //return non-breaked string

} //end of comment-remove-breaks function


function cmtx_comment_deny_long_words($comment) { //deny very long words

	$long_word_found = false; //initialise flag as false

	$comment = str_ireplace('<br />', ' ', $comment); //remove any <br /> tags
	$comment = str_ireplace('<p></p>', ' ', $comment); //remove any <p></p> tags
	$comment = strip_tags($comment); //strip any tags

	$words = explode(' ', $comment); //get words into array

	foreach ($words as $word) { //for each word
		if (cmtx_strlen($word) >= cmtx_setting('long_word_length_to_deny')) { //if word length is longer than allowed word length
			$long_word_found = true; //set flag as true
		}
	}

	if ($long_word_found) { //if long word was entered
		cmtx_error(CMTX_ERROR_MESSAGE_LONG_WORD); //reject user for entering long word
	}

} //end of comment-deny-long-words function


function cmtx_comment_check_capitals ($comment) { //checks comment for too many capital letters

	if (cmtx_is_encoding_iso($comment)) { //if encoding is ISO-8859-1

		$comment = preg_replace('/[^a-z]/i', '', $comment); //remove non-letters

		$number_of_letters = cmtx_strlen($comment); //number of letters

		$number_of_capitals = cmtx_strlen(preg_replace('/[^A-Z]/', '', $comment)); //number of capitals

		if ($number_of_letters != 0 && $number_of_letters > 3 && $number_of_capitals != 0) { //if check is appropriate

			$percentage_of_capitals = ($number_of_capitals / $number_of_letters) * 100; //percentage of capitals

			if ($percentage_of_capitals >= cmtx_setting('check_capitals_percentage')) { //if too many capitals
				if (cmtx_setting('check_capitals_action') == 'approve') { //if entering too many capitals should require approval
					cmtx_approve(CMTX_APPROVE_REASON_CAPITALS); //approve user for too many capitals
				} else if (cmtx_setting('check_capitals_action') == 'reject') { //if entering too many capitals should be rejected
					cmtx_error(CMTX_ERROR_MESSAGE_CAPITALS); //reject user for too many capitals
				} else if (cmtx_setting('check_capitals_action') == 'ban') { //if entering too many capitals should result in a ban
					cmtx_ban(CMTX_BAN_REASON_CAPITALS); //ban user for too many capitals
				}
			} //end of if-too-many-capitals

		}

	}

} //end of comment-check-capitals function


function cmtx_flood_control_delay() { //checks whether time since last comment is less than minimum delay

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$ip_address = cmtx_get_ip_address();

	//get time/date of most recent comment (if any) by current user
	if (cmtx_setting('flood_control_delay_all_pages')) { //for all pages
		$query = cmtx_db_query("SELECT `dated` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' ORDER BY `dated` DESC LIMIT 1");
	} else { //for current page
		$query = cmtx_db_query("SELECT `dated` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `page_id` = '$cmtx_page_id' ORDER BY `dated` DESC LIMIT 1");
	}

	if (cmtx_db_num_rows($query)) { //if previous comment by current user was found

		$result = cmtx_db_fetch_assoc($query);
		$time = strtotime($result['dated']);
		$difference = time() - $time;
		if ($difference < cmtx_setting('flood_control_delay_time')) { //if time since last comment is less than minimum allowed time
			cmtx_error(CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY); //reject user for consecutive comment
		}

	}

} //end of flood-control-delay function


function cmtx_flood_control_maximum() { //check amount of comments does not exceed set maximum within set period

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$now = strtotime(date('Y-m-d H:i:s')); //get current time
	$earlier = $now - (3600 * cmtx_setting('flood_control_maximum_period')); //subtract time period from current time
	$earlier = date('Y-m-d H:is', $earlier); //convert to normal date

	//count number of comments (if any) within past period by current user
	if (cmtx_setting('flood_control_maximum_all_pages')) { //for all pages
		$query = cmtx_db_query("SELECT COUNT(*) as `amount` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `dated` > '$earlier'");
	} else { //for current page
		$query = cmtx_db_query("SELECT COUNT(*) as `amount` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `page_id` = '$cmtx_page_id' AND `dated` > '$earlier'");
	}

	$result = cmtx_db_fetch_assoc($query);
	$amount = $result['amount'];
	if ($amount >= cmtx_setting('flood_control_maximum_amount')) { //if comment amount exceeds allowed amount
		cmtx_error(CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM); //reject user for too many comments within past period
	}

} //end of flood-control-maximum function


function cmtx_check_if_banned() { //check if user is banned

	global $cmtx_mysql_table_prefix; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$ban_found = false; //initialise flag as false

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `ip_address` = '$ip_address'"))) { //if user's IP address is found in 'bans' database table
		$ban_found = true; //set flag as true
	}

	if (isset($_COOKIE['Commentics-Ban']) && $_COOKIE['Commentics-Ban'] == 'Banned') { //if a ban cookie is found
		$ban_found = true; //set flag as true
	}

	if ($ban_found) { //if a ban was found
		echo '<h3>Commentics</h3>';
		echo '<div style="margin-bottom: 10px;"></div>';
		die(CMTX_BAN_MESSAGE_BANNED_OLD); //end scripting and output message to user explaining they were previously banned
	}

} //end of check-if-banned function


function cmtx_ban($reason) { //ban user

	global $cmtx_mysql_table_prefix, $cmtx_is_admin; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$reason = cmtx_sanitize($reason, true, true);

	if (!$cmtx_is_admin) { //if not administrator

		//insert user's IP address into 'bans' database table
		cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "bans` (`ip_address`, `reason`, `dated`) VALUES ('$ip_address', '$reason', NOW())");

		?><script type="text/javascript">
		// <![CDATA[
		jQuery.cookie('Commentics-Ban', 'Banned', { expires: <?php echo cmtx_setting('ban_cookie_days'); ?>, path: '/' });
		// ]]>
		</script><?php

		cmtx_notify_admin_new_ban($reason); //notify admin of new ban

		echo '<h3>Commentics</h3>';
		echo '<div style="margin-bottom: 10px;"></div>';
		die(CMTX_BAN_MESSAGE_BANNED_NEW); //end scripting and output message to user explaining they are now banned

	}

} //end of ban function


function cmtx_error($message) { //process error

	global $cmtx_error, $cmtx_error_message, $cmtx_error_total; //globalise variables

	$cmtx_error = true; //there is an error

	$cmtx_error_message .= '<li>' . $message . '</li>'; //concatenate to error message

	$cmtx_error_total ++; //accumulate total number of errors

} //end of error function


function cmtx_approve($reason) { //process approval

	global $cmtx_approve, $cmtx_approve_reason; //globalise variables

	$cmtx_approve = true; //there is an approval

	$cmtx_approve_reason .= $reason . "\r\n"; //concatenate to approval reasoning

} //end of approve function


function cmtx_approval_needed() { //determine whether approval is needed

	global $cmtx_approve, $cmtx_is_admin; //globalise variables
	
	if ($cmtx_is_admin) { //if it's the administrator
		return false; //no approval needed
	}

	if ($cmtx_approve) { //if there's an approval reason
		return true; //approval needed
	}
	
	if (cmtx_setting('approve_comments') && !cmtx_setting('trust_users')) { //if approving all and previous users are not trusted
		return true; //approval needed
	}
	
	if (cmtx_setting('approve_comments') && cmtx_setting('trust_users') && cmtx_user_trusted()) { //if approving all and previous users are trusted and user is trusted
		return false; //no approval needed
	}
	
	if (cmtx_setting('approve_comments') && cmtx_setting('trust_users') && !cmtx_user_trusted()) { //if approving all and previous users are trusted and user is not trusted
		return true; //approval needed
	}
	
	return false; //no approval needed

} //end of approval-needed function


function cmtx_user_trusted() { //check if user has previously posted an approved comment

	global $cmtx_name, $cmtx_mysql_table_prefix; //globalise variables
	
	$ip_address = cmtx_get_ip_address(); //get user's IP address
	
	//if the user's name and IP address match and an approved comment is found
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `name` = '$cmtx_name' AND `ip_address` = '$ip_address' AND `is_approved` = '1'"))) {
		return true; //user is trusted
	} else {
		return false; //user is not trusted
	}

} //end of user-trusted function
?>