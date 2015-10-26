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
?>
<!DOCTYPE html>
<html>
<head>
<title>Subscribers</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="noindex"/>
<style type="text/css"><!--
body {
	padding-left: 5px;
}

h1 {
	color: #636E75;
	font-size: 32px;
	font-weight: normal;
	margin-bottom: 10px;
	margin-top: 0;
}

.subscription_info_block {
	margin-bottom: 15px;
}

.subscription_info_label {
	float: left;
	width: 55px;
	font-weight: bold;
}

.subscription_header {
	background: none repeat scroll 0 0 #585858;
	color: #FFFFFF;
	height: 25px;
	padding-left: 5px;
	padding-top: 5px;
}

.subscription_block {
	margin-top: 10px;
	margin-bottom: 10px;
}

.subscription_custom_block {
	margin-bottom: -15px;
	margin-top: -13px;
}

.subscription_custom_text {
	color: #838B8B;
	font-size: 0.8em;
	margin-bottom: 8px;
}

.button {
	margin-top: 7px;
	background: url("images/buttons/gradient.gif") repeat-x scroll 0 100% #FFAC47;
	border-color: #ED6502 #A04300 #A04300 #ED6502;
	border-style: solid;
	border-width: 1px;
	color: #FFFFFF;
	cursor: pointer;
	font: bold 12px arial,helvetica,sans-serif;
	padding: 1px 7px 2px;
	text-align: center !important;
	white-space: nowrap;
}

.cancel_link {
	font-size: 0.8em;
}

.info, .success, .warning, .error {
	border: 1px solid;
	padding: 5px 5px 5px 25px;
	background-repeat: no-repeat;
	background-position: 5px center;
	position: relative;
	float: left;
	margin-bottom: 10px;
	box-shadow: 3px 3px 5px #888888;
}

.info {
	color: #00529B;
	background-color: #BDE5F8;
	background-image: url('images/messages/information.png');
}

.success {
	color: #4F8A10;
	background-color: #E8FCDC;
	background-image: url('images/messages/success.gif');
}

.warning {
	color: #9F6000;
	background-color: #FEEFB3;
	background-image: url('images/messages/warning.png');
}

.error {
	color: #D8000C;
	background-color: #FFBABA;
	background-image: url('images/messages/error.gif');
}
}--></style>

<script type="text/javascript">
// <![CDATA[
function show_hide(id) {
	if (id == 'all') {
		document.getElementById('subscription_custom_block').style.display = 'none';
	} else {
		document.getElementById('subscription_custom_block').style.display = 'block';
	}
}
// ]]>
</script>
</head>
<body>
<?php
//temporary solution while transitioning from 'uid' to 'id'
if (isset($_GET['uid'])) {
	$_GET['id'] = $_GET['uid'];
}

//set the path
$cmtx_path = '';

/* Database Connection */
require 'includes/db/connect.php'; //connect to database
if (!$cmtx_db_ok) { die(); }

//load function files
require_once $cmtx_path . 'includes/bootstrap/functions.php'; //load bootstrap file for functions

//load language files
require_once $cmtx_path . 'includes/bootstrap/language.php'; //load bootstrap file for language

if (!cmtx_setting('enabled_notify')) {
	die(CMTX_SUB_FEATURE_DISABLED);
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
?>

<h1><?php echo CMTX_SUB_HEADING; ?></h1>

<?php
if (isset($_GET['id'])) { //get subscriber

	$token = $_GET['id'];

	if (cmtx_strlen($token) != 20 || !ctype_alnum($token)) {
		?><div class="error"><?php echo CMTX_SUB_MSG_INVALID; ?></div><?php
		die();
	}
	
	$token = cmtx_sanitize($token, true, true);

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'"))) {
		$subscriber = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'");
		$subscriber = cmtx_db_fetch_assoc($subscriber);
	} else {
		?><div class="error"><?php echo CMTX_SUB_MSG_NO_SUBSCRIPTION; ?></div><?php
		die();
	}

} else {
	?><div class="error"><?php echo CMTX_SUB_MSG_NO_SUBSCRIPTION; ?></div><?php
	die();
}

if (isset($_GET['confirm'])) { //confirm

	if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token' AND `is_confirmed` = '0'"))) {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `is_confirmed` = '1' WHERE `token` = '$token'");
		?><div class="success"><?php echo CMTX_SUB_MSG_CONFIRMED; ?></div><?php
		?><div style="clear:left"></div><?php
	} else if (cmtx_db_num_rows(cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token' AND `is_confirmed` = '1'"))) {
		?><div class="warning"><?php echo CMTX_SUB_MSG_ALREADY_CONFIRMED; ?></div><?php
		?><div style="clear:left"></div><?php
	}

} else {
	cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `is_confirmed` = '1' WHERE `token` = '$token'");
}

if (isset($_GET['unsubscribe'])) { //unsubscribe

	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'");
	?><div class="success"><?php echo CMTX_SUB_MSG_UNSUBSCRIBED; ?></div><?php
	die();

}

if (isset($_POST['submit'])) { //save
	if (isset($_POST['to_all'])) {
		if ($_POST['to_all']) {
			cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_all` = '1' WHERE `token` = '$token'");
		} else {
			cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_all` = '0' WHERE `token` = '$token'");
		}
	}
	if (isset($_POST['to_admin'])) {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_admin` = '1' WHERE `token` = '$token'");
	} else {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_admin` = '0' WHERE `token` = '$token'");
	}
	if (isset($_POST['to_reply'])) {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_reply` = '1' WHERE `token` = '$token'");
	} else {
		cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "subscribers` SET `to_reply` = '0' WHERE `token` = '$token'");
	}
	?><div class="success"><?php echo CMTX_SUB_MSG_SETTINGS_SAVED; ?></div><?php
	?><div style="clear:left"></div><?php
}

$subscriber = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'");
$subscriber = cmtx_db_fetch_assoc($subscriber);
?>

<div class="subscription_info_block">
<label class="subscription_info_label"><?php echo CMTX_SUB_NAME; ?></label> <?php echo $subscriber['name']; ?>
<br/>
<label class="subscription_info_label"><?php echo CMTX_SUB_EMAIL; ?></label> <?php echo $subscriber['email']; ?>
</div>


<div class="subscription_header"><?php echo CMTX_SUB_HEADING_TYPE; ?></div>

<div class="subscription_block">
	<form action="<?php echo 'subscribers.php?id=' . $token; ?>" method="post">
		<?php if ($subscriber['to_all']) { ?> <input type="radio" name="to_all" value="1" checked="checked" onclick="show_hide('all')"/> <?php } else { ?> <input type="radio" name="to_all" value="1" onclick="show_hide('all')"/> <?php } ?> <?php echo CMTX_SUB_ALL_COMMENTS; ?>
		<br/>
		<?php if (!$subscriber['to_all']) { ?> <input type="radio" name="to_all" value="0" checked="checked" onclick="show_hide('custom')"/> <?php } else { ?> <input type="radio" name="to_all" value="0" onclick="show_hide('custom')"/> <?php } ?> <?php echo CMTX_SUB_CUSTOM; ?>

		<div id="subscription_custom_block" class="subscription_custom_block" <?php if ($subscriber['to_all']) { echo 'style="display:none;"'; } ?>>
			<br/>
			<div class="subscription_custom_text"><?php echo CMTX_SUB_ONLY; ?></div>

			<?php if ($subscriber['to_admin']) { ?> <input type="checkbox" name="to_admin" checked="checked"/> <?php } else { ?> <input type="checkbox" name="to_admin"/> <?php } ?> <?php echo CMTX_SUB_ADMIN_COMMENTS; ?>
			<?php if (cmtx_setting('show_reply')) { ?>
				<br/>
				<?php if ($subscriber['to_reply']) { ?> <input type="checkbox" name="to_reply" checked="checked"/> <?php } else { ?> <input type="checkbox" name="to_reply"/> <?php } ?> <?php echo CMTX_SUB_REPLY_COMMENTS; ?>
			<?php } ?>
		</div>
		<br/>
		<input type="submit" class="button" name="submit" value="<?php echo CMTX_SUB_SAVE; ?>" title="<?php echo CMTX_SUB_SAVE; ?>"/>
	</form>
</div>


<div class="subscription_header"><?php echo CMTX_SUB_HEADING_CANCEL; ?></div>

<div class="subscription_block">
<a href="<?php echo 'subscribers.php?id=' . $token . '&amp;unsubscribe=1'; ?>" class="cancel_link" title="<?php echo CMTX_SUB_LINK_CANCEL_TITLE; ?>"><?php echo CMTX_SUB_LINK_CANCEL; ?></a>
</div>

</body>
</html>