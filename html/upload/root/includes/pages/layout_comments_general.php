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

<h3><?php echo CMTX_TITLE_COMMENTS_GENERAL; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$comments_order = $_POST['comments_orders'];
if (isset($_POST['show_comment_count'])) { $show_comment_count = 1; } else { $show_comment_count = 0; }
if (isset($_POST['show_says'])) { $show_says = 1; } else { $show_says = 0; }

$comments_order_san = cmtx_sanitize($comments_order);

cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$comments_order_san' WHERE `title` = 'comments_order'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$show_comment_count' WHERE `title` = 'show_comment_count'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$show_says' WHERE `title` = 'show_says'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_GENERAL; ?>

<p />

<form name="layout_comments_general" id="layout_comments_general" action="index.php?page=layout_comments_general" method="post">
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_ORDER; ?></label>
<?php
$comments_orders = "<select name='comments_orders'>
<option value='1'>" . CMTX_FIELD_VALUE_SORT_BY_1 . "</option>
<option value='2'>" . CMTX_FIELD_VALUE_SORT_BY_2 . "</option>
<option value='3'>" . CMTX_FIELD_VALUE_SORT_BY_3 . "</option>
<option value='4'>" . CMTX_FIELD_VALUE_SORT_BY_4 . "</option>
<option value='5'>" . CMTX_FIELD_VALUE_SORT_BY_5 . "</option>
<option value='6'>" . CMTX_FIELD_VALUE_SORT_BY_6 . "</option>
</select>";
$comments_orders = str_ireplace("'".cmtx_setting('comments_order')."'", "'".cmtx_setting('comments_order')."' selected='selected'", $comments_orders);
echo $comments_orders;
?>
<?php cmtx_generate_hint(CMTX_HINT_COMMENTS_ORDER); ?>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_COMMENT_COUNT; ?></label> <?php if (cmtx_setting('show_comment_count')) { ?> <input type="checkbox" checked="checked" name="show_comment_count"/> <?php } else { ?> <input type="checkbox" name="show_comment_count"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_COMMENT_COUNT); ?>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_SAYS; ?></label> <?php if (cmtx_setting('show_says')) { ?> <input type="checkbox" checked="checked" name="show_says"/> <?php } else { ?> <input type="checkbox" name="show_says"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_SAYS); ?>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>