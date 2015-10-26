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

<h3><?php echo CMTX_TITLE_FORM_ORDER; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$sort_order_fields = $_POST['sort_order_fields'];
$sort_order_captchas = $_POST['sort_order_captchas'];
$sort_order_checkboxes = $_POST['sort_order_checkboxes'];
$sort_order_buttons = $_POST['sort_order_buttons'];

$sort_order_fields_san = cmtx_sanitize($sort_order_fields);
$sort_order_captchas_san = cmtx_sanitize($sort_order_captchas);
$sort_order_checkboxes_san = cmtx_sanitize($sort_order_checkboxes);
$sort_order_buttons_san = cmtx_sanitize($sort_order_buttons);

cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$sort_order_fields_san' WHERE `title` = 'sort_order_fields'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$sort_order_captchas_san' WHERE `title` = 'sort_order_captchas'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$sort_order_checkboxes_san' WHERE `title` = 'sort_order_checkboxes'");
cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$sort_order_buttons_san' WHERE `title` = 'sort_order_buttons'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_ORDER; ?>

<p />

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#fields').sortable({
		update: function() {
			var newOrder = $(this).sortable('toArray').toString();
			newOrder = newOrder.replace(/field_/g, '');
			$('#sort_order_fields').val(newOrder);
		}
	});
});
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#comment').sortable();
});
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#captchas').sortable({
		update: function() {
			var newOrder = $(this).sortable('toArray').toString();
			newOrder = newOrder.replace(/captcha_/g, '');
			$('#sort_order_captchas').val(newOrder);
		}
	});
});
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#checkboxes').sortable({
		update: function() {
			var newOrder = $(this).sortable('toArray').toString();
			newOrder = newOrder.replace(/checkbox_/g, '');
			$('#sort_order_checkboxes').val(newOrder);
		}
	});
});
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#buttons').sortable({
		update: function() {
			var newOrder = $(this).sortable('toArray').toString();
			newOrder = newOrder.replace(/button_/g, '');
			$('#sort_order_buttons').val(newOrder);
		}
	});
});
// ]]>
</script>

<form name="layout_form_order" id="layout_form_order" action="index.php?page=layout_form_order" method="post">

<div id="fields" class="sortable">

	<?php
	$elements = explode(',', cmtx_setting('sort_order_fields'));
	foreach ($elements as $element) {
		switch ($element) {
			case '1':
			output_name();
			break;
			case '2':
			output_email();
			break;
			case '3':
			output_website();
			break;
			case '4':
			output_town();
			break;
			case '5':
			output_country();
			break;
			case '6':
			output_rating();
			break;
		}
	}
	?>
	
	<?php function output_name() { ?> <div id="field_1" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_NAME, ':') ?></div> <?php } ?>
    <?php function output_email() { ?> <div id="field_2" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_EMAIL, ':') ?></div> <?php } ?>
    <?php function output_website() { ?> <div id="field_3" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_WEBSITE, ':') ?></div> <?php } ?>
    <?php function output_town() { ?> <div id="field_4" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_TOWN, ':') ?></div> <?php } ?>
    <?php function output_country() { ?> <div id="field_5" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_COUNTRY, ':') ?></div> <?php } ?>
    <?php function output_rating() { ?> <div id="field_6" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_RATING, ':') ?></div> <?php } ?>
	
</div>

<input type="hidden" name="sort_order_fields" id="sort_order_fields" value="<?php echo cmtx_setting('sort_order_fields'); ?>"/>

<div style="margin-top:20px;"></div>

<div id="comment" class="sortable">
	<div class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_COMMENT, ':') ?></div>
</div>

<div style="margin-top:20px;"></div>

<div id="captchas" class="sortable">

	<?php
	$elements = explode(',', cmtx_setting('sort_order_captchas'));
	foreach ($elements as $element) {
		switch ($element) {
			case '1':
			output_question();
			break;
			case '2':
			output_captcha();
			break;
		}
	}
	?>
	
	<?php function output_question() { ?> <div id="captcha_1" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_QUESTION, ':') ?></div> <?php } ?>
    <?php function output_captcha() { ?> <div id="captcha_2" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_CAPTCHA, ':') ?></div> <?php } ?>
	
</div>

<input type="hidden" name="sort_order_captchas" id="sort_order_captchas" value="<?php echo cmtx_setting('sort_order_captchas'); ?>"/>

<div style="margin-top:20px;"></div>

<div id="checkboxes" class="sortable">

	<?php
	$elements = explode(',', cmtx_setting('sort_order_checkboxes'));
	foreach ($elements as $element) {
		switch ($element) {
			case '1':
			output_notify();
			break;
			case '2':
			output_remember();
			break;
			case '3':
			output_privacy();
			break;
			case '4':
			output_terms();
			break;
		}
	}
	?>
	
	<?php function output_notify() { ?> <div id="checkbox_1" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_NOTIFY, ':') ?></div> <?php } ?>
    <?php function output_remember() { ?> <div id="checkbox_2" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_COOKIE, ':') ?></div> <?php } ?>
    <?php function output_privacy() { ?> <div id="checkbox_3" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_PRIVACY, ':') ?></div> <?php } ?>
    <?php function output_terms() { ?> <div id="checkbox_4" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_TERMS, ':') ?></div> <?php } ?>
	
</div>

<input type="hidden" name="sort_order_checkboxes" id="sort_order_checkboxes" value="<?php echo cmtx_setting('sort_order_checkboxes'); ?>"/>

<div style="margin-top:20px;"></div>

<div id="buttons" class="sortable">

	<?php
	$elements = explode(',', cmtx_setting('sort_order_buttons'));
	foreach ($elements as $element) {
		switch ($element) {
			case '1':
			output_submit();
			break;
			case '2':
			output_preview();
			break;
		}
	}
	?>
	
	<?php function output_submit() { ?> <div id="button_1" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_VALUE_SUBMIT, ':') ?></div> <?php } ?>
    <?php function output_preview() { ?> <div id="button_2" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo rtrim(CMTX_FIELD_LABEL_PREVIEW, ':') ?></div> <?php } ?>
	
</div>

<input type="hidden" name="sort_order_buttons" id="sort_order_buttons" value="<?php echo cmtx_setting('sort_order_buttons'); ?>"/>

<div style="clear:left;"></div>

<p />

<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>

</form>