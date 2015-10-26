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

function cmtx_sanitize($value, $stage_one = true, $stage_two = true) { //sanitizes data
    
	$value = trim($value); //strip any space from beginning and end of string
	
	$value = preg_replace('/  */', ' ', $value); //replace multiple spaces with one space

	if ($stage_one) {
		$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //convert special characters, including quotes, to HTML entities
	}

	if ($stage_two) {
		$value = cmtx_db_real_escape_string($value); //escape any special characters for database
	}
		
	return $value; //return sanitized string
	
} //end of sanitize function


function cmtx_encode($value) { //encode text

	$value = htmlspecialchars($value, ENT_QUOTES);
	
	return $value;
	
} //end of encode function


function cmtx_decode($value) { //decode text

	$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
	
	return $value;
	
} //end of decode function


function cmtx_url_encode($value) { //encode URL

	$value = cmtx_url_encode_spaces($value);
	$value = cmtx_encode($value);
	
	return $value;
	
} //end of url-encode function


function cmtx_url_decode($value) { //decode URL

	$value = cmtx_url_decode_spaces($value);
	$value = cmtx_decode($value);
	
	return $value;
	
} //end of url-decode function


function cmtx_url_encode_spaces($value) { //encode URL spaces

	$value = str_ireplace(' ', '%20', $value);
	
	return $value;
	
} //end of url-encode-spaces function


function cmtx_url_decode_spaces($value) { //decode URL spaces

	$value = str_ireplace('%20', ' ', $value);
	
	return $value;
	
} //end of url-decode-spaces function


function cmtx_define($name, $value) { //defines a constant

	if (!defined($name)) {
		
		$value = cmtx_sanitize($value, true, false); //encode value
		
		define($name, $value);
		
	}

} //end of define function


function cmtx_current_page() { //gets the URL of the current page

	$url = cmtx_url_decode('http' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://' . strtolower($_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI']);

	return $url;

} //end of current-page function


function cmtx_get_viewer($user_agent) { //get the viewer

	if (stristr($user_agent, 'AOL')) {
		$title = 'AOL';
		$image = 'aol.png';
	} else if (stristr($user_agent, 'Ask Jeeves')) {
		$title = 'Ask Jeeves';
		$image = 'ask.png';
	} else if (stristr($user_agent, 'Baidu')) {
		$title = 'Baidu';
		$image = 'baidu.png';
	} else if (stristr($user_agent, 'Bingbot')) {
		$title = 'Bing';
		$image = 'bing.png';
	} else if (stristr($user_agent, 'Googlebot')) {
		$title = 'Google';
		$image = 'google.png';
	} else if (stristr($user_agent, 'Yahoo')) {
		$title = 'Yahoo';
		$image = 'yahoo.png';
	} else if (stristr($user_agent, 'Yandex')) {
		$title = 'Yandex';
		$image = 'yandex.png';
	} else {
		$title = CMTX_TABLE_PERSON;
		$image = 'person.png';
	}
	
	$viewer = '<td><img src="images/viewers/' . $image . '" class="viewer" title="' . $title . '" alt="' . $title . '"></td>';
	$viewer .= '<td>' . $title . '</td>';

    return $viewer;
	
} //end of get-viewer function


function cmtx_get_random_key($length) { //generates a random key

    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $key;
	
} //end of get-random-key function


function cmtx_get_current_version() { //gets current version

	global $cmtx_mysql_table_prefix; //globalise variables

	$current_version_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "version` ORDER BY `dated` DESC LIMIT 1");
	$current_version_result = cmtx_db_fetch_assoc($current_version_query);
	$current_version = $current_version_result['version'];
	
	return $current_version;

} //end of get-current-version function


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

	global $cmtx_mysql_table_prefix, $cmtx_parent_emails; //globalise variables
	
	$page_id = cmtx_sanitize($page_id);
	$comment_id = cmtx_sanitize($comment_id);

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");
	
	$page_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$page_id'");
	$page_result = cmtx_db_fetch_assoc($page_query);
	$page_reference = cmtx_decode($page_result['reference']);
	$page_url = cmtx_decode($page_result['url']);
	
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, $page_result["url"])); //get the permalink of the comment
	
	if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt')) {
		$subscriber_notification_basic_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_basic.txt'; //build path to custom subscriber notification basic email file
	} else {
		$subscriber_notification_basic_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_basic.txt'; //build path to subscriber notification basic email file
	}
		
	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email
	
	$count = 0; //count how many emails are sent
	
	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if (!in_array($subscriber['email'], $cmtx_parent_emails)) {
		
			$body = file_get_contents($subscriber_notification_basic_email_file); //get the file's contents
			
			$email = $subscriber['email'];
			
			$name = cmtx_prepare_name_for_email($subscriber['name']); //prepare name for email
			
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
	
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' WHERE `id` = '$comment_id'"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' WHERE `id` = '$comment_id'"); //set how many were sent (if any)
	
} //end of notify-subscribers-basic function


function cmtx_notify_subscribers_reply($poster, $comment, $page_id, $comment_id) { //notify subscribers of reply

	global $cmtx_mysql_table_prefix, $cmtx_parent_emails; //globalise variables
	
	$page_id = cmtx_sanitize($page_id);
	$comment_id = cmtx_sanitize($comment_id);

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");
	
	$page_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$page_id'");
	$page_result = cmtx_db_fetch_assoc($page_query);
	$page_reference = cmtx_decode($page_result['reference']);
	$page_url = cmtx_decode($page_result['url']);
	
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, $page_result['url'])); //get the permalink of the comment
	
	if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt')) {
		$subscriber_notification_reply_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_reply.txt'; //build path to custom subscriber notification reply email file
	} else {
		$subscriber_notification_reply_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_reply.txt'; //build path to subscriber notification reply email file
	}
	
	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email
	
	$count = 0; //count how many emails are sent
	
	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if (in_array($subscriber['email'], $cmtx_parent_emails)) {
		
			$body = file_get_contents($subscriber_notification_reply_email_file); //get the file's contents
			
			$email = $subscriber['email'];
			
			$name = cmtx_prepare_name_for_email($subscriber['name']); //prepare name for email
			
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
	
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' WHERE `id` = '$comment_id'"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' WHERE `id` = '$comment_id'"); //set how many were sent (if any)
	
} //end of notify-subscribers-reply function


function cmtx_notify_subscribers_admin($poster, $comment, $page_id, $comment_id) { //notify subscribers of admin comment

	global $cmtx_mysql_table_prefix, $cmtx_parent_emails; //globalise variables
	
	$page_id = cmtx_sanitize($page_id);
	$comment_id = cmtx_sanitize($comment_id);

	//select confirmed subscribers from database
	$subscribers = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");
	
	$page_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$page_id'");
	$page_result = cmtx_db_fetch_assoc($page_query);
	$page_reference = cmtx_decode($page_result['reference']);
	$page_url = cmtx_decode($page_result['url']);
	
	$comment_url = cmtx_decode(cmtx_get_permalink($comment_id, $page_result['url'])); //get the permalink of the comment
	
	if (file_exists('../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt')) {
		$subscriber_notification_admin_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/custom/subscriber_notification_admin.txt'; //build path to custom subscriber notification admin email file
	} else {
		$subscriber_notification_admin_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/user/subscriber_notification_admin.txt'; //build path to subscriber notification admin email file
	}

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email
	
	$count = 0; //count how many emails are sent
	
	while ($subscriber = cmtx_db_fetch_assoc($subscribers)) { //while there are subscribers
	
		if (!in_array($subscriber['email'], $cmtx_parent_emails)) {
		
			$body = file_get_contents($subscriber_notification_admin_email_file); //get the file's contents
			
			$email = $subscriber['email'];
			
			$name = cmtx_prepare_name_for_email($subscriber['name']); //prepare name for email
			
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
	
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' WHERE `id` = '$comment_id'"); //mark comment as sent
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = `sent_to` + '$count' WHERE `id` = '$comment_id'"); //set how many were sent (if any)
	
} //end of notify-subscribers-admin function


function cmtx_prepare_name_for_email($name) { //prepares name for email
	
	$name = cmtx_decode($name);
	
	return $name;
	
} //end of prepare-name-for-email function


function cmtx_prepare_comment_for_email($comment) { //prepares comment for email
	
	$comment = str_ireplace("<br />", "\r\n", $comment);
	$comment = str_ireplace("<br/>", "\r\n", $comment);
	$comment = str_ireplace("<br>", "\r\n", $comment);
	
	$comment = str_ireplace("<p></p>", "\r\n\r\n", $comment);
	$comment = str_ireplace("<p />", "\r\n\r\n", $comment);
	$comment = str_ireplace("<p/>", "\r\n\r\n", $comment);
	
	$comment = str_ireplace("<li>", "- ", $comment);
	$comment = str_ireplace("</li>", "\r\n", $comment);
	$comment = str_ireplace("\r\n</ul>", "", $comment);
	$comment = str_ireplace("\r\n</ol>", "", $comment);
	
	$comment = strip_tags($comment);
	
	$comment = cmtx_decode($comment);
	
	$comment = preg_replace('/(\r\n){3,}/', "\r\n\r\n", $comment);
	
	$comment = trim($comment);
	
	return $comment;
	
} //end of prepare-comment-for-email function


function cmtx_get_ip_address() { //get IP address
	
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
    } else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		} else {
			$ip_address = getenv('REMOTE_ADDR');
		}
    }
	
	$ip_address = cmtx_sanitize($ip_address);
	
	return $ip_address; //return IP address
	
} //end of get-ip-address function


function cmtx_valid_account($username, $password) { //check whether account is valid
	
	global $cmtx_mysql_table_prefix; //globalise variables

	$username = cmtx_sanitize($username);
	$password = cmtx_sanitize($password);
	
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username' AND `is_enabled` = '0'"))) {
		return '1'; //Disabled
	}
	
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username' AND `login_attempts` >= 10"))) {
		return '2'; //Locked
	}
	
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username' AND `password` = '$password'"))) {
		return '3'; //Okay
	}
	
	return; //Wrong
	
} //end of valid-account function


function cmtx_get_admin_id() { //get id of administrator
	
	global $cmtx_mysql_table_prefix; //globalise variables

	$username = $_SESSION['cmtx_username'];
	
	$username = cmtx_sanitize($username);
	
	$query = cmtx_db_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username'");
	$result = cmtx_db_fetch_assoc($query);
	$admin_id = $result['id'];
	
	return cmtx_sanitize($admin_id);
	
} //end of get-admin-id function


function cmtx_tip_of_the_day() { //get an admin tip
	
	$admin_tips = file('includes/words/admin_tips.txt');
	
	$amount = count($admin_tips);
	
	$day = date('z');
 
    $position = (int) $day % $amount;
	
    $tip = $admin_tips[$position];

	return $tip;

} //end of tip-of-the-day function


function cmtx_delete_replies($id) { //delete replies of given comment
	
	global $cmtx_mysql_table_prefix;
	
	$id = cmtx_sanitize($id);
	
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '$id'");
	
	while ($comments = cmtx_db_fetch_assoc($query)) {
	
		$id = $comments['id'];
	
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "voters` WHERE `comment_id` = '$id'");
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "reporters` WHERE `comment_id` = '$id'");
	
		cmtx_delete_replies($id);
	
	}

} //end of delete-replies function


function cmtx_unapprove_replies($id) { //unapprove replies of given comment
	
	global $cmtx_mysql_table_prefix;
	
	$id = cmtx_sanitize($id);
	
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '$id'");
	
	while ($comments = cmtx_db_fetch_assoc($query)) {
	
		$id = $comments['id'];

		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_approved` = '0' WHERE `id` = '$id'");
	
		cmtx_unapprove_replies($id);
	
	}

} //end of unapprove-replies function


function cmtx_error_reporting($path) { //error reporting

	if (cmtx_setting('error_reporting_admin')) { //if error reporting is turned on for admin panel
		@error_reporting(-1); //show every possible error
		if (cmtx_setting('error_reporting_method') == 'log') { //if errors should be logged to file
			@ini_set('display_errors', 0); //don't display errors
			@ini_set('log_errors', 1); //log errors
			@ini_set('error_log', $path); //set log path
		} else { //if errors should be displayed on screen
			@ini_set('display_errors', 1); //display errors
			@ini_set('log_errors', 0); //don't log errors
		}
	} else { //if error reporting is turned off for admin panel
		@error_reporting(0); //turn off all error reporting
		@ini_set('display_errors', 0); //don't display errors
		@ini_set('log_errors', 0); //don't log errors
	}

} //end of error-reporting function


function cmtx_text_finder($text, $file, $case) { //search file

	global $text_found;
	
	$text = str_ireplace("'", "\'", $text);

	if (substr($file, 0, 1) == '.') {
		$path = str_ireplace('../', '/' . cmtx_setting('commentics_folder') . '/', $file);
	} else {
		$path = '/' . cmtx_setting('commentics_folder') . '/' . cmtx_setting('admin_folder') . '/' . $file;
	}
	
	$file = file($file);
	
	foreach ($file as $line_number => $line) {
	
		$line_number++;
		
		if ($line_number > 25) { //don't search copyright section
		
			$matches = array();
			
			if (preg_match('/DEFINE\(\'(.*?)\',\s*\'(.*)\'\);/i', $line, $matches)) {
				
				$value = $matches[2];
				
				if ($case) { //if case-sensitive
					if (strpos($value, $text) !== false) {
						printf(CMTX_FIELD_VALUE_FOUND_AT, $line_number);
						echo ' ' . $path;
						echo '<br/>';
						echo '<code>' . $line . '</code>';
						echo '<p/>';
						$text_found = true;
					}
				} else {
					if (stripos($value, $text) !== false) {
						printf(CMTX_FIELD_VALUE_FOUND_AT, $line_number);
						echo ' ' . $path;
						echo '<br/>';
						echo '<code>' . $line . '</code>';
						echo '<p/>';
						$text_found = true;
					}
				}
			}
		}
	}
	
} //end of text-finder function


function cmtx_set_csrf_form_key() { //apply CSRF protection to form

	echo '<input type="hidden" name="csrf_key" value="' . $_SESSION['cmtx_csrf_key'] . '"/>';
	
} //end of set-csrf-form-key function


function cmtx_check_csrf_form_key() { //check the CSRF protection key in form

	if (!isset($_POST['csrf_key']) || !isset($_SESSION['cmtx_csrf_key'])) {
		echo 'A CSRF attack has been prevented.';
		die();
	}

	if ($_POST['csrf_key'] != $_SESSION['cmtx_csrf_key']) {
		echo 'A CSRF attack has been prevented.';
		die();
	}
	
} //end of check-csrf-form-key function


function cmtx_check_csrf_url_key() { //check the CSRF protection key in URL

	if (!isset($_GET['key']) || !isset($_SESSION['cmtx_csrf_key'])) {
		return false;
	}

	if ($_GET['key'] != $_SESSION['cmtx_csrf_key']) {
		return false;
	}
	
	return true;
	
} //end of check-csrf-url-key function


function cmtx_record_exists($id, $table) { //check whether the record exists

	global $cmtx_mysql_table_prefix;
	
	$id = cmtx_sanitize($id);
	$table = cmtx_sanitize($table);

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . $table . "` WHERE `id` = '$id'"))) {
		return true;
	} else {
		return false;
	}
	
} //end of record-exists function


function cmtx_generate_hint($hint) { //show the hint box

	$hint = str_ireplace("'", "\'", $hint); //replace ' with \'
	$hint = str_ireplace("\"", "&quot;", $hint); //replace " with &quot;
	
	?><a href="" class="hintanchor" onclick="return false;" onmouseover="showhint('<?php echo $hint; ?>', this, event, '')">[?]</a><?php
	
} //end of generate-hint function


function cmtx_escape_js($text) { //escape a JavaScript string for output

	$text = str_ireplace("'", "\'", $text); //replace ' with \'
	
	return $text;

} //end of escape-js function


function cmtx_restrict_page($page) { //check whether page is restricted

	global $cmtx_mysql_table_prefix;

	$allowed_pages_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `id` = '" . cmtx_get_admin_id() . "'");
	$allowed_pages_result = cmtx_db_fetch_assoc($allowed_pages_query);
	$restrict_pages = $allowed_pages_result['restrict_pages'];
	$allowed_pages = $allowed_pages_result['allowed_pages'];
	
	if ($page != 'dashboard' && $restrict_pages && !in_array($page, explode(',', $allowed_pages))) {
		return true;
	} else {
		return false;
	}

} //end of restrict-page function


function cmtx_page_checkbox($page, $id, $indent) { //display page checkbox in edit_admin

	global $cmtx_mysql_table_prefix;

	$allowed_pages_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `id` = '$id'");
	$allowed_pages_result = cmtx_db_fetch_assoc($allowed_pages_query);
	$allowed_pages = $allowed_pages_result['allowed_pages'];
	
	echo '<label class="edit_administrator">&nbsp;</label>';
	
	if (in_array($page, explode(',', $allowed_pages))) {
		echo '<input type="checkbox" style="margin-left:' . $indent . 'px;" checked="checked" name="allowed_pages[]" value="' . $page . '"/>';
	} else {
		echo '<input type="checkbox" style="margin-left:' . $indent . 'px;" name="allowed_pages[]" value="' . $page . '"/>';
	}

} //end of page-checkbox function


function cmtx_check_attempts() { //check attempts on login page

	global $cmtx_mysql_table_prefix;
	
	$ip_address = cmtx_get_ip_address();

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "attempts` WHERE `ip_address` = '$ip_address' AND `amount` >= 3"))) {
		$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "attempts` WHERE `ip_address` = '$ip_address' AND `amount` >= 3");
		$result = cmtx_db_fetch_assoc($query);
		$time = strtotime($result['dated']);
		$difference = time() - $time;
		if ($difference < 60 * 30) {
			header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?action=failed');
			die();
		}
	}

} //end of check-attempts function


function cmtx_add_attempt() { //record attempt on login page

	global $cmtx_mysql_table_prefix;
	
	$ip_address = cmtx_get_ip_address();
	$username = cmtx_sanitize($_POST['username']);

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "attempts` WHERE `ip_address` = '$ip_address'"))) {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "attempts` SET `amount` = `amount` + 1, `dated` = NOW() WHERE `ip_address` = '$ip_address'");
	} else {
		cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "attempts` (`ip_address`, `amount`, `dated`) VALUES ('$ip_address', '1', NOW());");
	}
	
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username'"))) {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "admins` SET `login_attempts` = `login_attempts` + 1 WHERE `username` = '$username'");
	}

} //end of add-attempt function


function cmtx_last_activity($seconds) { //converts seconds to a friendly time

	$days = floor($seconds / 86400);

	if ($days >= 1 && $days <= 9) {
		$time = '0' . $days . 'd ' . gmdate('H\h i\m s\s', $seconds);
	} else if ($days >= 10) {
		$time = $days . 'd ' . gmdate('H\h i\m s\s', $seconds);
	} else {
		if ($seconds >= 3600) {
			$time = gmdate('H\h i\m s\s', $seconds);
		} else {
			$time = gmdate('i\m s\s', $seconds);
		}
	}
	
	return $time;

} //end of last-activity function


function cmtx_delete_attempts() { //delete attempts on login page

	global $cmtx_mysql_table_prefix;
	
	$ip_address = cmtx_get_ip_address();

	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "attempts` WHERE `ip_address` = '$ip_address'");

} //end of delete-attempts function


function cmtx_is_approved($id) { //is comment approved

	global $cmtx_mysql_table_prefix;
	
	$id = cmtx_sanitize($id);
	
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$result = cmtx_db_fetch_assoc($query);
	$is_approved = $result['is_approved'];
	
	if ($is_approved) {
		return true;
	} else {
		return false;
	}

} //end of is-approved function


function cmtx_is_sent($id) { //is comment sent

	global $cmtx_mysql_table_prefix;
	
	$id = cmtx_sanitize($id);
	
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$result = cmtx_db_fetch_assoc($query);
	$is_sent = $result['is_sent'];
	
	if ($is_sent) {
		return true;
	} else {
		return false;
	}

} //end of is-sent function


function cmtx_log_out($text) { //log out

	session_regenerate_id(true);
	session_destroy();
	session_unset();
	session_write_close();
	header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?action=' . $text);
	die();

} //end of log-out function


function cmtx_set_time_zone($time_zone) { //set the time zone

	@date_default_timezone_set($time_zone); //set time zone PHP
	
	@cmtx_db_query("SET time_zone = '" . date("P") . "'"); //set time zone DB

} //end of set-time-zone function


function cmtx_email($to_email, $to_name, $subject, $body, $from_email, $from_name, $reply_email) { //sends an email

	global $cmtx_path; //globalise variables
	
	if (cmtx_setting('transport_method') == 'php-basic') {
	
		//set email headers
		$headers = 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $reply_email . "\r\n";
		$headers .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
		
		//set recipient name
		if (!empty($to_name)) { $to_email = $to_name . " <$to_email>"; }
		
		//send email
		@mail($to_email, $subject, $body, $headers);
	
	} else {
	
		require_once $cmtx_path . 'includes/external/swift_mailer/lib/swift_required.php'; //load Swift Mailer

		//set the transport method
		if (cmtx_setting('transport_method') == 'php') {
			$transport = Swift_MailTransport::newInstance();
		} else if (cmtx_setting('transport_method') == 'smtp') {
			$transport = Swift_SmtpTransport::newInstance();
			$transport->setHost(cmtx_setting('smtp_host'));
			$transport->setPort(cmtx_setting('smtp_port'));
			if (cmtx_setting('smtp_encrypt') == 'ssl') {
				$transport->setEncryption('ssl');
			} else if (cmtx_setting('smtp_encrypt') == 'tls') {
				$transport->setEncryption('tls');
			}
			if (cmtx_setting('smtp_username') && cmtx_setting('smtp_password')) {
				$transport->setUsername(cmtx_setting('smtp_username'));
				$transport->setPassword(cmtx_setting('smtp_password'));
			}
		} else if (cmtx_setting('transport_method') == 'sendmail') {
			$transport = Swift_SendmailTransport::newInstance(cmtx_setting('sendmail_path') . ' -bs');
		}

		//create the Mailer using the created Transport
		$mailer = Swift_Mailer::newInstance($transport);

		//create the message
		$message = Swift_Message::newInstance();
		
		//give the message a subject
		$message->setSubject($subject);

		//set the From address
		$message->setFrom(array($from_email => $from_name));

		//set the Reply-To address
		$message->setReplyTo($reply_email);

		//set the To address
		if (empty($to_name)) { $message->setTo($to_email); } else { $message->setTo(array($to_email => $to_name)); }

		//give it a body
		$message->setBody($body);

		//set the format of message
		$message->setContentType('text/plain');

		//set the charset as UTF-8
		$message->setCharset('UTF-8');

		//set the content-transfer-encoding to 8bit
		$message->setEncoder(Swift_Encoding::get8BitEncoding());

		//set the maximum line length to 1000
		$message->setMaxLineLength(1000);

		//send the message
		$result = $mailer->send($message);
	
	}

} //end of email function


function cmtx_get_permalink($id, $url) { //build the permalink

	preg_match('/cmtx_sort=[0-9]/', $_SERVER['REQUEST_URI'], $match);

	if (!empty($match[0])) {
		$sort = $match[0] . '&amp;';
	} else {
		$sort = '';
	}

	if (strstr($url, '?') && strstr($url, '=')) {
		$url .= '&amp;' . $sort . 'cmtx_perm=' . $id . '#cmtx_perm_' . $id;
	} else {
		$url .= '?' . $sort . 'cmtx_perm=' . $id . '#cmtx_perm_' . $id;
	}

	return $url;

} //end of get-permalink function


function cmtx_setting($title) { //gets a setting

	global $cmtx_mysql_table_prefix;
	
	$result = cmtx_db_query("SELECT `value` FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = '$title'");
	$result = cmtx_db_fetch_assoc($result);
	
	return $result['value'];

} //end of setting function


function cmtx_format_date($date) { //format a date

	//Months

	$date = str_ireplace('January', CMTX_JANUARY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Jan', CMTX_JANUARY_SHORT, $date);
    }
	
	$date = str_ireplace('February', CMTX_FEBRUARY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Feb', CMTX_FEBRUARY_SHORT, $date);
    }
	
	$date = str_ireplace('March', CMTX_MARCH, $date, $count);
	if (!$count) {
        $date = str_ireplace('Mar', CMTX_MARCH_SHORT, $date);
    }
	
	$date = str_ireplace('April', CMTX_APRIL, $date, $count);
	if (!$count) {
        $date = str_ireplace('Apr', CMTX_APRIL_SHORT, $date);
    }
	
	$date = str_ireplace('May', CMTX_MAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('May', CMTX_MAY_SHORT, $date);
    }
	
	$date = str_ireplace('June', CMTX_JUNE, $date, $count);
	if (!$count) {
        $date = str_ireplace('Jun', CMTX_JUNE_SHORT, $date);
    }
	
	$date = str_ireplace('July', CMTX_JULY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Jul', CMTX_JULY_SHORT, $date);
    }
	
	$date = str_ireplace('August', CMTX_AUGUST, $date, $count);
	if (!$count) {
        $date = str_ireplace('Aug', CMTX_AUGUST_SHORT, $date);
    }
	
	$date = str_ireplace('September', CMTX_SEPTEMBER, $date, $count);
	if (!$count) {
        $date = str_ireplace('Sep', CMTX_SEPTEMBER_SHORT, $date);
    }
	
	$date = str_ireplace('October', CMTX_OCTOBER, $date, $count);
	if (!$count) {
        $date = str_ireplace('Oct', CMTX_OCTOBER_SHORT, $date);
    }
	
	$date = str_ireplace('November', CMTX_NOVEMBER, $date, $count);
	if (!$count) {
        $date = str_ireplace('Nov', CMTX_NOVEMBER_SHORT, $date);
    }
	
	$date = str_ireplace('December', CMTX_DECEMBER, $date, $count);
	if (!$count) {
        $date = str_ireplace('Dec', CMTX_DECEMBER_SHORT, $date);
    }
	
	//Days
	
	$date = str_ireplace('Monday', CMTX_MONDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Mon', CMTX_MONDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Tuesday', CMTX_TUESDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Tue', CMTX_TUESDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Wednesday', CMTX_WEDNESDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Wed', CMTX_WEDNESDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Thursday', CMTX_THURSDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Thu', CMTX_THURSDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Friday', CMTX_FRIDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Fri', CMTX_FRIDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Saturday', CMTX_SATURDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Sat', CMTX_SATURDAY_SHORT, $date);
    }
	
	$date = str_ireplace('Sunday', CMTX_SUNDAY, $date, $count);
	if (!$count) {
        $date = str_ireplace('Sun', CMTX_SUNDAY_SHORT, $date);
    }
	
	return $date;

} //end of format-date function


function cmtx_delete_installer($dir) { //delete installer folder

	if (is_dir($dir)) {
	
		$objects = scandir($dir);
		
		foreach ($objects as $object) {
			if ($object != '.' && $object != '..') {
				if (filetype($dir . '/' . $object) == 'dir') {
					cmtx_delete_installer($dir . '/' . $object);
				} else {
					@unlink($dir . '/' . $object);
				}
			}
		}
		
	reset($objects);
	@rmdir($dir);
	
   }

} //end of delete-installer function
?>