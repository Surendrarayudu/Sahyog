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

function cmtx_sanitize($value, $stage_one, $stage_two) { //sanitizes data

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


function cmtx_strip_slashes($value) { //strip slashes

	if (is_array($value)) {
		$value = array_map('cmtx_strip_slashes', $value);
	} else if (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value->{$key} = cmtx_strip_slashes($data);
		}
	} else {
		$value = stripslashes($value);
	}

	return $value;

} //end of strip-slashes function


function cmtx_page_setup() { //page setup

	global $cmtx_page_id; //globalise variables
	
	if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'Commentics') {
		die();
	}

	cmtx_identifier_exists(); //check identifier exists
	cmtx_get_page_details(); //get page details
	cmtx_validate_page_details(); //validate page details
	
	if (cmtx_page_exists()) { //if the page exists
		$cmtx_page_id = cmtx_get_page_id(); //set its ID
	} else { //if the page does not exist
		if (cmtx_setting('delay_pages')) { //don't create the page yet
			$cmtx_page_id = ''; //set a blank ID
		} else {
			cmtx_create_page(); //create the page
		}
	}

} //end of page-setup function


function cmtx_identifier_exists() { //check identifier exists

	global $cmtx_identifier; //globalise variables

	$cmtx_identifier = trim($cmtx_identifier); //remove any space at beginning and end
	
	if (empty($cmtx_identifier)) { //if no identifier

		echo '<h3>Commentics</h3>';
		echo '<div style="margin-bottom: 10px;"></div>';
		?><span class="cmtx_page_alert"><?php echo CMTX_ALERT_MESSAGE_NO_IDENTIFIER; ?></span><?php
		die();

	}

} //end of identifier-exists function


function cmtx_get_page_details() { //get page details

	global $cmtx_identifier, $cmtx_reference, $cmtx_url, $cmtx_parameters; //globalise variables

	//get URL
	$url = cmtx_url_decode(cmtx_current_page());

	//remove URL parameters if configured
	if (isset($cmtx_parameters)) {
		if (empty($cmtx_parameters) || $cmtx_parameters == 'none') {
			$url = strtok($url, '?');
		} else {
			$queries = explode(',', $cmtx_parameters);
			$query_string = '';
			foreach ($queries as $query) {
				if (isset($_GET[$query])) { $query_string .= $query . '=' . $_GET[$query] . '&'; } else { die(); }
			}
			if (preg_match('/[&$]/i', $query_string)) { //if query ends in &
				$query_string = substr($query_string, 0, -1); //remove &
			}
			$url = strtok($url, '?');
			$url .= '?' . $query_string;
		}
	}

	//ensure reference is set
	if (!isset($cmtx_reference)) {
		$cmtx_reference = '';
	}

	//get title/heading
	if (stristr($cmtx_identifier, 'cmtx_title') || stristr($cmtx_reference, 'cmtx_title') || stristr($cmtx_identifier, 'cmtx_h1') || stristr($cmtx_reference, 'cmtx_h1')) {

		@ini_set('user_agent', 'Commentics'); //set user-agent
		
		$path = cmtx_url_encode($url);
		
		if (extension_loaded('curl')) { //if cURL is available
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Commentics');
			curl_setopt($ch, CURLOPT_URL, $path);
			$file = curl_exec($ch);
			curl_close($ch);
		} else if ((bool)ini_get('allow_url_fopen')) { //if allow_url_fopen is available
			$file = file_get_contents($path);
		}
		if (isset($file) && !empty($file)) {
			if (stristr($cmtx_identifier, 'cmtx_title') || stristr($cmtx_reference, 'cmtx_title')) {
				if (preg_match('/<title>(.+?)<\/title>/i', $file, $match)) {
					$cmtx_identifier = str_ireplace('cmtx_title', $match[1], $cmtx_identifier);
					$cmtx_reference = str_ireplace('cmtx_title', $match[1], $cmtx_reference);
				} else {
					$cmtx_identifier = str_ireplace('cmtx_title', 'Title tag not found', $cmtx_identifier);
					$cmtx_reference = str_ireplace('cmtx_title', 'Title tag not found', $cmtx_reference);
				}
			}
			if (stristr($cmtx_identifier, 'cmtx_h1') || stristr($cmtx_reference, 'cmtx_h1')) {
				if (preg_match('/<h1>(.+?)<\/h1>/i', $file, $match)) {
					$cmtx_identifier = str_ireplace('cmtx_h1', $match[1], $cmtx_identifier);
					$cmtx_reference = str_ireplace('cmtx_h1', $match[1], $cmtx_reference);
				} else {
					$cmtx_identifier = str_ireplace('cmtx_h1', 'H1 tag not found', $cmtx_identifier);
					$cmtx_reference = str_ireplace('cmtx_h1', 'H1 tag not found', $cmtx_reference);
				}
			}
		} else {
			$cmtx_identifier = str_ireplace('cmtx_title', 'Server incapable', $cmtx_identifier);
			$cmtx_reference = str_ireplace('cmtx_title', 'Server incapable', $cmtx_reference);
			$cmtx_identifier = str_ireplace('cmtx_h1', 'Server incapable', $cmtx_identifier);
			$cmtx_reference = str_ireplace('cmtx_h1', 'Server incapable', $cmtx_reference);
		}
	}

	//get page filename
	if (stristr($cmtx_identifier, 'cmtx_filename') || stristr($cmtx_reference, 'cmtx_filename')) {
		if (isset($_SERVER['SCRIPT_NAME'])) {
			$cmtx_identifier = str_ireplace('cmtx_filename', $_SERVER['SCRIPT_NAME'], $cmtx_identifier);
			$cmtx_reference = str_ireplace('cmtx_filename', basename($_SERVER['SCRIPT_NAME']), $cmtx_reference);
		} else {
			$cmtx_identifier = str_ireplace('cmtx_filename', 'Server incapable', $cmtx_identifier);
			$cmtx_reference = str_ireplace('cmtx_filename', 'Server incapable', $cmtx_reference);
		}
	}

	//set identifier as reference
	if (stristr($cmtx_identifier, 'cmtx_reference')) {
		$cmtx_identifier = str_ireplace('cmtx_reference', $cmtx_reference, $cmtx_identifier);
	}

	//set reference as identifier
	if (stristr($cmtx_reference, 'cmtx_identifier')) {
		$cmtx_reference = str_ireplace('cmtx_identifier', $cmtx_identifier, $cmtx_reference);
	}

	//set reference as URL
	if (stristr($cmtx_reference, 'cmtx_url')) {
		$cmtx_reference = str_ireplace('cmtx_url', $cmtx_url, $cmtx_reference);
	}

	//set identifier as URL
	if (stristr($cmtx_identifier, 'cmtx_url')) {
		$cmtx_temp = $url;
		$cmtx_temp = str_ireplace('www.', '', $cmtx_temp); //remove 'www.' if there
		$cmtx_temp = str_ireplace('index.php', '', $cmtx_temp); //remove 'index.php' if there
		$cmtx_temp = str_ireplace('index.htm', '', $cmtx_temp); //remove 'index.htm' if there
		$cmtx_temp = str_ireplace('index.html', '', $cmtx_temp); //remove 'index.html' if there
		$cmtx_temp = str_ireplace('index.shtml', '', $cmtx_temp); //remove 'index.shtml' if there
		$cmtx_temp = str_ireplace('https://', 'http://', $cmtx_temp); //remove SSL if there
		$cmtx_temp = preg_replace('/&cmtx_page=[0-9]*/', '', $cmtx_temp); //remove cmtx_page=x if there (1)
		$cmtx_temp = preg_replace('/cmtx_page=[0-9]*&/', '', $cmtx_temp); //remove cmtx_page=x if there (2)
		$cmtx_temp = preg_replace('/cmtx_page=[0-9]*/', '', $cmtx_temp); //remove cmtx_page=x if there (3)
		$cmtx_temp = preg_replace('/&cmtx_sort=[0-9]*/', '', $cmtx_temp); //remove cmtx_sort=x if there (1)
		$cmtx_temp = preg_replace('/cmtx_sort=[0-9]*&/', '', $cmtx_temp); //remove cmtx_sort=x if there (2)
		$cmtx_temp = preg_replace('/cmtx_sort=[0-9]*/', '', $cmtx_temp); //remove cmtx_sort=x if there (3)
		$cmtx_temp = preg_replace('/&cmtx_perm=[0-9]*/', '', $cmtx_temp); //remove cmtx_perm=x if there (1)
		$cmtx_temp = preg_replace('/cmtx_perm=[0-9]*&/', '', $cmtx_temp); //remove cmtx_perm=x if there (2)
		$cmtx_temp = preg_replace('/cmtx_perm=[0-9]*/', '', $cmtx_temp); //remove cmtx_perm=x if there (3)
		$cmtx_temp = strtolower($cmtx_temp); //convert to lowercase
		$cmtx_identifier = str_ireplace('cmtx_url', $cmtx_temp, $cmtx_identifier);
	}
	
	//get URL
	$cmtx_url = cmtx_url_decode(cmtx_current_page());
	
	if (cmtx_setting('lower_pages')) {
		$cmtx_url = strtolower($cmtx_url);
	}
	
	$cmtx_url = cmtx_url_encode_spaces($cmtx_url); //encode spaces

} //end of get-page-details function


function cmtx_validate_page_details() { //validate page details

	global $cmtx_identifier, $cmtx_reference, $cmtx_url; //globalise variables

	if (cmtx_strlen($cmtx_identifier) > 250 || cmtx_strlen($cmtx_reference) > 250 || cmtx_strlen($cmtx_url) > 250) { //if invalid details

		echo '<h3>Commentics</h3>';
		echo '<div style="margin-bottom: 10px;"></div>';
	
		if (cmtx_strlen($cmtx_identifier) > 250) { ?><span class="cmtx_page_alert"><?php echo CMTX_ALERT_MESSAGE_INVALID_IDENTIFIER; ?></span><div style="margin-bottom:5px;"></div><?php }
		if (cmtx_strlen($cmtx_reference) > 250) { ?><span class="cmtx_page_alert"><?php echo CMTX_ALERT_MESSAGE_INVALID_REFERENCE; ?></span><div style="margin-bottom:5px;"></div><?php }
		if (cmtx_strlen($cmtx_url) > 250) { ?><span class="cmtx_page_alert"><?php echo CMTX_ALERT_MESSAGE_INVALID_URL; ?></span><div style="margin-bottom:5px;"></div><?php }
		
		die();
		
	}

} //end of validate-page-details function


function cmtx_page_exists() { //check if the page exists

	global $cmtx_identifier, $cmtx_mysql_table_prefix; //globalise variables
	
	//sanitize data
	$cmtx_identifier_2 = cmtx_sanitize($cmtx_identifier, true, true);

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `identifier` = '$cmtx_identifier_2'"))) { //if page exists
		return true;
	} else {
		return false;
	}

} //end of page-exists function


function cmtx_get_page_id() { //get the page ID

	global $cmtx_identifier, $cmtx_mysql_table_prefix; //globalise variables
	
	//sanitize data
	$cmtx_identifier = cmtx_sanitize($cmtx_identifier, true, true);

	$query = cmtx_db_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `identifier` = '$cmtx_identifier'"); //get page ID
	$result = cmtx_db_fetch_assoc($query);
	$cmtx_page_id = $result['id'];
	
	return $cmtx_page_id;

} //end of get-page-id function


function cmtx_create_page() { //create page

	global $cmtx_identifier, $cmtx_reference, $cmtx_url, $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables
	
	//sanitize data
	$cmtx_identifier = cmtx_sanitize($cmtx_identifier, true, true);
	$cmtx_reference = cmtx_sanitize($cmtx_reference, true, true);
	$cmtx_url = cmtx_sanitize($cmtx_url, true, true);

	cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "pages` (`identifier`, `reference`, `url`, `is_form_enabled`, `dated`) VALUES ('$cmtx_identifier', '$cmtx_reference', '$cmtx_url', 1, NOW())");

	$cmtx_page_id = cmtx_db_insert_id();

} //end of create-page function


function cmtx_get_page_reference() { //get page reference

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$query = cmtx_db_query("SELECT `reference` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$cmtx_page_id'");
	$result = cmtx_db_fetch_assoc($query);
	$page_reference = $result['reference'];

	return $page_reference;

} //end of get-page-reference function


function cmtx_get_page_url() { //get page URL

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$query = cmtx_db_query("SELECT `url` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$cmtx_page_id'");
	$result = cmtx_db_fetch_assoc($query);
	$page_url = $result['url'];

	return $page_url;

} //end of get-page-url function


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

	$ip_address = cmtx_sanitize($ip_address, true, true);

	return $ip_address; //return IP address

} //end of get-ip-address function


function cmtx_get_user_agent() { //get user agent

	if (isset($_SERVER['HTTP_USER_AGENT']) && cmtx_strlen($_SERVER['HTTP_USER_AGENT']) < 250) {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = cmtx_sanitize($user_agent, true, true);
	} else {
		$user_agent = '';
	}

	return $user_agent; //return user agent

} //end of get-user-agent function


function cmtx_in_maintenance() { //check if in maintenance mode

	global $cmtx_is_admin; //globalise variables

	if (cmtx_setting('maintenance_mode') && !$cmtx_is_admin) {
		?><h3>Commentics</h3>
		<div style="margin-bottom: 10px;"></div>
		<div class="cmtx_maintenance"><?php
		echo cmtx_setting('maintenance_message');
		?></div><?php
		return true;
	} else {
		return false;
	}

} //end of in-maintenance function


function cmtx_is_administrator() { //is the user the administrator

	global $cmtx_mysql_table_prefix; //globalise variables

	//initialise values
	$administrator_found = false;
	$admin_ip_address_found = false;
	$admin_cookie_found = false;
	$detect_admin = false;
	$detect_method = 'both';

	//check IP address
	$ip_address = cmtx_get_ip_address();
	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1'"))) {
		$admin_ip_address_found = true; //set IP address flag as true
	}

	//check cookie
	if (isset($_COOKIE['Commentics-Admin']) && ctype_alnum($_COOKIE['Commentics-Admin']) && cmtx_strlen($_COOKIE['Commentics-Admin']) == 20) {
		$cookie_value = cmtx_sanitize($_COOKIE['Commentics-Admin'], true, true);
		if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1'"))) {
			$admin_cookie_found = true; //set cookie flag as true
		}
	}

	//get detection settings
	if ($admin_ip_address_found || $admin_cookie_found) {

		if ($admin_ip_address_found) {

			$detection_settings = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1' LIMIT 1");
			$detection_settings = cmtx_db_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings['detect_admin'];
			$detect_method = $detection_settings['detect_method'];

		} else {

			$detection_settings = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1");
			$detection_settings = cmtx_db_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings['detect_admin'];
			$detect_method = $detection_settings['detect_method'];		

		}

	}

	if ($detect_admin) { //if administrator should be detected

		if ($detect_method == 'ip_address') {
			if ($admin_ip_address_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == 'cookie') {
			if ($admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == 'either') {
			if ($admin_ip_address_found || $admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == 'both') {
			if ($admin_ip_address_found && $admin_cookie_found) {
				$administrator_found = true;
			}
		}

	}

	return $administrator_found;

} //end of is-administrator function


function cmtx_prepare_name_for_email($name) { //prepares name for email

	$name = cmtx_strip_slashes($name);

	$name = cmtx_decode($name);

	return $name;

} //end of prepare-name-for-email function


function cmtx_prepare_email_for_email($email) { //prepares email address for email

	$email = cmtx_strip_slashes($email);

	$email = cmtx_decode($email);

	return $email;

} //end of prepare-email-for-email function


function cmtx_prepare_comment_for_email($comment, $slashes = true) { //prepares comment for email

	if ($slashes) {
		$comment = cmtx_strip_slashes($comment);
	}

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

	$comment = preg_replace("/(\r\n){3,}/", "\r\n\r\n", $comment);

	$comment = trim($comment);

	return $comment;

} //end of prepare-comment-for-email function


function cmtx_get_random_key($length) { //generates a random key

	$characters = '0123456789abcdefghijklmnopqrstuvwxyz'; //allowed characters
	$key = '';
	for ($i = 0; $i < $length; $i++) {
		$key .= $characters[mt_rand(0, cmtx_strlen($characters)-1)];
	}

	return $key;

} //end of get-random-key function


function cmtx_add_viewer() { //add viewer to database

	global $cmtx_mysql_table_prefix, $cmtx_reference, $cmtx_url, $cmtx_is_admin; //globalise variables
	
	cmtx_unban_viewer(); //unban viewer if requested by admin
	
	if (cmtx_setting('viewers_enabled') && !$cmtx_is_admin) { //if viewers feature is enabled and viewer is not admin
	
		$ip_address = cmtx_get_ip_address();
		$user_agent = cmtx_get_user_agent();
		$page_reference = cmtx_sanitize($cmtx_reference, true, true);
		$page_url = cmtx_sanitize($cmtx_url, true, true);

		$timestamp = time();
		$timeout = $timestamp - cmtx_setting('viewers_timeout');

		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "viewers` WHERE `timestamp` < '$timeout'");
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "viewers` WHERE `ip_address` = '$ip_address'");
		cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "viewers` (`user_agent`, `ip_address`, `page_reference`, `page_url`, `timestamp`) VALUES ('$user_agent', '$ip_address', '$page_reference', '$page_url', '$timestamp')");
	
	}

} //end of add-viewer function


function cmtx_get_query($type) { //gets query string from URL

	$query = parse_url(cmtx_current_page(), PHP_URL_QUERY);

	if ($type == 'form' && !empty($query)) {
		$query = '?' . $query;
	} else if ($type == 'page' && !empty($query)) {
		$query = '&' . $query;
	} else if ($type == 'sort' && !empty($query)) {
		$query = '&' . $query;
	} else {
		$query = '';
	}

	$query = preg_replace('/&cmtx_page=[0-9]*/', '', $query);
	$query = preg_replace('/cmtx_page=[0-9]*&/', '', $query);
	$query = preg_replace('/cmtx_page=[0-9]*/', '', $query);

	$query = preg_replace('/&cmtx_perm=[0-9]*/', '', $query);
	$query = preg_replace('/cmtx_perm=[0-9]*&/', '', $query);
	$query = preg_replace('/cmtx_perm=[0-9]*/', '', $query);

	if ($type != 'page') {
		$query = preg_replace('/&cmtx_sort=[0-9]*/', '', $query);
		$query = preg_replace('/cmtx_sort=[0-9]*&/', '', $query);
		$query = preg_replace('/cmtx_sort=[0-9]*/', '', $query);
	}

	$query = rtrim($query, '?');

	return $query;

} //end of get-query function


function cmtx_unban_viewer() { //unban viewer if requested

	global $cmtx_mysql_table_prefix; //globalise variables

	$bans = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `unban` = '1'");

	while ($ban = cmtx_db_fetch_assoc($bans)) {

		if (cmtx_get_ip_address() == $ban['ip_address']) {

			?><script type="text/javascript">
			// <![CDATA[
			jQuery.removeCookie('Commentics-Ban', { path: '/' });
			// ]]>
			</script><?php
			
			cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `id` = '" . $ban['id'] . "'");
		}

	}

} //end of unban-viewer function


function cmtx_strlen($entry) { //get length of string

	if (function_exists('mb_strlen') && is_callable('mb_strlen')) {
		$length = mb_strlen($entry, 'UTF-8');
	} else {
		$length = strlen(utf8_decode($entry));
	}

	return $length;

} //end of strlen function


function cmtx_unapprove_replies($id) { //unapprove replies of given comment

	global $cmtx_mysql_table_prefix;

	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '$id'");

	while ($comments = cmtx_db_fetch_assoc($query)) {

		$id = $comments['id'];

		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_approved` = '0' WHERE `id` = '$id'");

		cmtx_unapprove_replies($id);

	}

} //end of unapprove-replies function


function cmtx_error_reporting($path) { //error reporting

	if (cmtx_setting('error_reporting_frontend')) { //if error reporting is turned on for frontend
		@error_reporting(-1); //show every possible error
		if (cmtx_setting('error_reporting_method') == 'log') { //if errors should be logged to file
			@ini_set('display_errors', 0); //don't display errors
			@ini_set('log_errors', 1); //log errors
			@ini_set('error_log', $path); //set log path
		} else { //if errors should be displayed on screen
			@ini_set('display_errors', 1); //display errors
			@ini_set('log_errors', 0); //don't log errors
		}
	} else { //if error reporting is turned off for frontend
		@error_reporting(0); //turn off all error reporting
		@ini_set('display_errors', 0); //don't display errors
		@ini_set('log_errors', 0); //don't log errors
	}

} //end of error-reporting function


function cmtx_session_set() { //is a session available

	if (session_id() != '') {
		return true;
	} else {
		return false;
	}

} //end of session-set function


function cmtx_escape_js($text) { //escape a JavaScript string for output

	$text = str_ireplace("'", "\'", $text); //replace ' with \'

	return $text;

} //end of escape-js function


function cmtx_set_time_zone($time_zone) { //set the time zone

	@date_default_timezone_set($time_zone); //set time zone PHP

	@cmtx_db_query("SET time_zone = '" . date('P') . "'"); //set time zone DB

} //end of set-time-zone function


function cmtx_commentics_url() { //gets the URL to Commentics

	$url = cmtx_url_decode('http' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://' . strtolower($_SERVER['HTTP_HOST']) . parse_url(cmtx_setting('commentics_url'), PHP_URL_PATH));
	
	$url = cmtx_url_encode($url);
	
	if (!parse_url(cmtx_setting('commentics_url'), PHP_URL_PATH) || !filter_var($url, FILTER_VALIDATE_URL)) {
		$url = cmtx_url_encode(cmtx_setting('commentics_url'));
	}

	return $url;

} //end of commentics-url function


function cmtx_current_page() { //gets the URL of the current page

	$url = cmtx_url_decode('http' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://' . strtolower($_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI']);

	return $url;

} //end of current-page function


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
	
		if (!class_exists('Swift')) {
			require_once $cmtx_path . 'includes/external/swift_mailer/lib/swift_required.php'; //load Swift Mailer
		}

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


function cmtx_parsing($cmtx_start_time) { //display parsing information

	global $cmtx_is_admin, $cmtx_query_time, $cmtx_query_count;
	
	if (cmtx_setting('display_parsing') && $cmtx_is_admin) {
		
		$cmtx_end_time = microtime(true);
		
		$cmtx_time = $cmtx_end_time - $cmtx_start_time;
		
		$cmtx_php_time = $cmtx_time - $cmtx_query_time;
		
		$cmtx_parsing = sprintf(CMTX_TEXT_PARSING, round($cmtx_time, 5));
		$cmtx_parsing .= '<br/>';
		$cmtx_parsing .= '<b>PHP</b>: ' . round($cmtx_php_time, 5) . 's | ' . '<b>SQL</b>: ' . round($cmtx_query_time, 5) . 's (' . $cmtx_query_count . ' ' . CMTX_TEXT_QUERIES . ')';
		
		?><script type="text/javascript">
		// <![CDATA[
		document.getElementById('cmtx_parsing').innerHTML = '<?php echo $cmtx_parsing; ?>';
		// ]]>
		</script><?php
		
	}

} //end of parsing function


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
?>
