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
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP; ?></a>
</div>

<h3><?php echo CMTX_TITLE_SYSTEM; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$site_name = $_POST['site_name'];
$time_zone = $_POST['time_zone'];
$site_domain = $_POST['site_domain'];
$site_url = $_POST['site_url'];
$commentics_folder = $_POST['commentics_folder'];
$commentics_url = $_POST['commentics_url'];
$admin_folder = $_POST['admin_folder'];
$mysqldump_path = $_POST['mysqldump_path'];
if (isset($_POST['enabled_wysiwyg'])) { $enabled_wysiwyg = 1; } else { $enabled_wysiwyg = 0; }
if (isset($_POST['display_parsing'])) { $display_parsing = 1; } else { $display_parsing = 0; }
$limit_comments = $_POST['limit_comments'];
$admin_cookie_days = $_POST['admin_cookie_days'];

$site_name_san = cmtx_sanitize($site_name);
$time_zone_san = cmtx_sanitize($time_zone);
$site_domain_san = cmtx_sanitize($site_domain);
$site_url_san = cmtx_sanitize($site_url);
$commentics_folder_san = cmtx_sanitize($commentics_folder);
$commentics_url_san = cmtx_sanitize($commentics_url);
$admin_folder_san = cmtx_sanitize($admin_folder);
$mysqldump_path_san = cmtx_sanitize($mysqldump_path);
$limit_comments_san = (int)$limit_comments;
$admin_cookie_days_san = (int)$admin_cookie_days;

cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$site_name_san' WHERE `title` = 'site_name'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$time_zone_san' WHERE `title` = 'time_zone'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$site_domain_san' WHERE `title` = 'site_domain'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$site_url_san' WHERE `title` = 'site_url'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$commentics_folder_san' WHERE `title` = 'commentics_folder'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$commentics_url_san' WHERE `title` = 'commentics_url'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_folder_san' WHERE `title` = 'admin_folder'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$mysqldump_path_san' WHERE `title` = 'mysqldump_path'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$enabled_wysiwyg' WHERE `title` = 'enabled_wysiwyg'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$display_parsing' WHERE `title` = 'display_parsing'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$limit_comments_san' WHERE `title` = 'limit_comments'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_cookie_days_san' WHERE `title` = 'admin_cookie_days'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_SYSTEM; ?>

<p />

<form name="settings_system" id="settings_system" action="index.php?page=settings_system" method="post">
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_SITE_NAME; ?></label> <input type="text" required name="site_name" size="35" maxlength="250" value="<?php echo cmtx_setting('site_name'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_SITE_NAME); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_TIME_ZONE; ?></label>
<?php
$selected_tz = cmtx_setting('time_zone');
$time_zones = DateTimeZone::listIdentifiers();
echo '<select name="time_zone">';
foreach ($time_zones as $time_zone) {
	if ($time_zone == $selected_tz) {
		echo '<option selected="selected" value="' . $time_zone . '">' . $time_zone . '</option>';
	} else {
		echo '<option value="' . $time_zone . '">' . $time_zone . '</option>';
	}
}
echo '</select>';
?>
<?php cmtx_generate_hint(CMTX_HINT_TIME_ZONE); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_SITE_DOMAIN; ?></label> <input type="text" required name="site_domain" size="35" maxlength="250" value="<?php echo cmtx_setting('site_domain'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_SITE_DOMAIN); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_SITE_URL; ?></label> <input type="text" required name="site_url" size="35" maxlength="250" value="<?php echo cmtx_setting('site_url'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_SITE_URL); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_COMMENTICS_FOLDER; ?></label> <input type="text" required name="commentics_folder" size="35" maxlength="250" value="<?php echo cmtx_setting('commentics_folder'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_COMMENTICS_FOLDER); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_COMMENTICS_URL; ?></label> <input type="text" required name="commentics_url" size="35" maxlength="250" value="<?php echo cmtx_setting('commentics_url'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_COMMENTICS_URL); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_ADMIN_FOLDER; ?></label> <input type="text" required name="admin_folder" size="35" maxlength="250" value="<?php echo cmtx_setting('admin_folder'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_ADMIN_FOLDER); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_MYSQL_DUMP; ?></label> <input type="text" name="mysqldump_path" size="35" maxlength="250" value="<?php echo cmtx_setting('mysqldump_path'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_MYSQL_DUMP); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_WYSIWYG; ?></label> <?php if (cmtx_setting('enabled_wysiwyg')) { ?> <input type="checkbox" checked="checked" name="enabled_wysiwyg"/> <?php } else { ?> <input type="checkbox" name="enabled_wysiwyg"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_WYSIWYG); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_DISPLAY_PARSING; ?></label> <?php if (cmtx_setting('display_parsing')) { ?> <input type="checkbox" checked="checked" name="display_parsing"/> <?php } else { ?> <input type="checkbox" name="display_parsing"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_PARSING); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_LIMIT_COMMENTS; ?></label> <input type="text" required name="limit_comments" size="1" maxlength="250" value="<?php echo cmtx_setting('limit_comments'); ?>"/>
<?php cmtx_generate_hint(CMTX_HINT_LIMIT_COMMENTS); ?>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_ADMIN_COOKIE_DAYS; ?></label> <input type="text" required name="admin_cookie_days" size="1" maxlength="3" value="<?php echo cmtx_setting('admin_cookie_days'); ?>"/> <span class='note'><?php echo CMTX_NOTE_DAYS; ?></span>
<?php cmtx_generate_hint(CMTX_HINT_ADMIN_COOKIE_DAYS); ?>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>