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

<?php if (!isset($cmtx_path)) { die('Access Denied.'); } ?>

<script type="text/javascript">
// <![CDATA[
function cmtx_add_tags(sTag, fTag) {

	var frm = document.forms['commentics'];

	//remember cursor position
	var scrollTop = frm.cmtx_comment.scrollTop;
	var scrollLeft = frm.cmtx_comment.scrollLeft;

	var obj = document.commentics.cmtx_comment;

	obj.focus();

	if (document.selection && document.selection.createRange) { // Internet Explorer
		sel = document.selection.createRange();
		if (sel.parentElement() == obj) {
			sel.text = sTag + sel.text + fTag;
		}
	}

	else if (typeof(obj) != 'undefined') { // Firefox
		var longueur = parseInt(obj.value.length);
		var selStart = obj.selectionStart;
		var selEnd = obj.selectionEnd;
		obj.value = obj.value.substring(0,selStart) + sTag + obj.value.substring(selStart,selEnd) + fTag + obj.value.substring(selEnd,longueur);
	}

	else {
		obj.value += sTag + fTag;
	}
  
	cmtx_text_counter(); //update the counter
  
	//set cursor position
	frm.cmtx_comment.scrollTop = scrollTop;
	frm.cmtx_comment.scrollLeft = scrollLeft;

	frm.cmtx_comment.focus();
  
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function cmtx_text_counter() {

	<?php if (cmtx_setting('enabled_counter')) { ?>

	var field = document.commentics.cmtx_comment;
	var maxlimit = <?php echo cmtx_setting('comment_maximum_characters');?>;

	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	} else {
		document.getElementById('cmtx_counter').innerHTML = maxlimit - field.value.length;
	}

	<?php } ?>
}
// ]]>
</script>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_bullet')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_bullet').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_bullet_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_BULLET_DIALOG_INSERT); ?>': function() {

					var tag = '';
					
					var item_1 = jQuery('#cmtx_bullet_dialog_field_1').val();
					var item_2 = jQuery('#cmtx_bullet_dialog_field_2').val();
					var item_3 = jQuery('#cmtx_bullet_dialog_field_3').val();
					var item_4 = jQuery('#cmtx_bullet_dialog_field_4').val();
					var item_5 = jQuery('#cmtx_bullet_dialog_field_5').val();
					
					var items = new Array(item_1, item_2, item_3, item_4, item_5);
					
					for (var i = 0; i < 5; i++) {
							var item = items[i];
							item = jQuery.trim(item);
							if (item != null && item != '') {
								tag = tag + '<?php echo CMTX_BB_CODE_TAG_ITEM_1; ?>' + item + '<?php echo CMTX_BB_CODE_TAG_ITEM_2; ?>\r\n';
							}
					}
					
					if (tag != null && tag != '') {
						tag = '<?php echo CMTX_BB_CODE_TAG_BULLET_1; ?>\r\n' + tag + '<?php echo CMTX_BB_CODE_TAG_BULLET_2; ?>';
						cmtx_add_tags('', tag);
					}
					
					jQuery('#cmtx_bullet_dialog_field_1').val('');
					jQuery('#cmtx_bullet_dialog_field_2').val('');
					jQuery('#cmtx_bullet_dialog_field_3').val('');
					jQuery('#cmtx_bullet_dialog_field_4').val('');
					jQuery('#cmtx_bullet_dialog_field_5').val('');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_BULLET_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_bullet_dialog_field_1').val('');
					jQuery('#cmtx_bullet_dialog_field_2').val('');
					jQuery('#cmtx_bullet_dialog_field_3').val('');
					jQuery('#cmtx_bullet_dialog_field_4').val('');
					jQuery('#cmtx_bullet_dialog_field_5').val('');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_bullet_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_numeric')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_numeric').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_numeric_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_NUMERIC_DIALOG_INSERT); ?>': function() {

					var tag = '';
					
					var item_1 = jQuery('#cmtx_numeric_dialog_field_1').val();
					var item_2 = jQuery('#cmtx_numeric_dialog_field_2').val();
					var item_3 = jQuery('#cmtx_numeric_dialog_field_3').val();
					var item_4 = jQuery('#cmtx_numeric_dialog_field_4').val();
					var item_5 = jQuery('#cmtx_numeric_dialog_field_5').val();
					
					var items = new Array(item_1, item_2, item_3, item_4, item_5);
					
					for (var i = 0; i < 5; i++) {
							var item = items[i];
							item = jQuery.trim(item);
							if (item != null && item != '') {
								tag = tag + '<?php echo CMTX_BB_CODE_TAG_ITEM_1; ?>' + item + '<?php echo CMTX_BB_CODE_TAG_ITEM_2; ?>\r\n';
							}
					}
					
					if (tag != null && tag != '') {
						tag = '<?php echo CMTX_BB_CODE_TAG_NUMERIC_1; ?>\r\n' + tag + '<?php echo CMTX_BB_CODE_TAG_NUMERIC_2; ?>';
						cmtx_add_tags('', tag);
					}
					
					jQuery('#cmtx_numeric_dialog_field_1').val('');
					jQuery('#cmtx_numeric_dialog_field_2').val('');
					jQuery('#cmtx_numeric_dialog_field_3').val('');
					jQuery('#cmtx_numeric_dialog_field_4').val('');
					jQuery('#cmtx_numeric_dialog_field_5').val('');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_NUMERIC_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_numeric_dialog_field_1').val('');
					jQuery('#cmtx_numeric_dialog_field_2').val('');
					jQuery('#cmtx_numeric_dialog_field_3').val('');
					jQuery('#cmtx_numeric_dialog_field_4').val('');
					jQuery('#cmtx_numeric_dialog_field_5').val('');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_numeric_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_link')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_link').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_link_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_LINK_DIALOG_INSERT); ?>': function() {

					var link = jQuery('#cmtx_link_dialog_field_1').val();
					
					link = jQuery.trim(link);
					
					if (link != null && link != '' && link != 'http://') {
					
						var text = jQuery('#cmtx_link_dialog_field_2').val();
						
						text = jQuery.trim(text);
						
						if (text != null && text != '') {
						
							var tag = '<?php echo CMTX_BB_CODE_TAG_LINK_2; ?>' + link + '<?php echo CMTX_BB_CODE_TAG_LINK_3; ?>' + text + '<?php echo CMTX_BB_CODE_TAG_LINK_4; ?>';
							cmtx_add_tags('', tag);
						
						} else {
					
							var tag = '<?php echo CMTX_BB_CODE_TAG_LINK_1; ?>' + link + '<?php echo CMTX_BB_CODE_TAG_LINK_4; ?>';
							cmtx_add_tags('', tag);
						
						}
					
					}
					
					jQuery('#cmtx_link_dialog_field_1').val('http://');
					jQuery('#cmtx_link_dialog_field_2').val('');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_LINK_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_link_dialog_field_1').val('http://');
					jQuery('#cmtx_link_dialog_field_2').val('');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_link_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_email')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_email').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_email_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_EMAIL_DIALOG_INSERT); ?>': function() {

					var email = jQuery('#cmtx_email_dialog_field_1').val();
					
					email = jQuery.trim(email);
					
					if (email != null && email != '') {
					
						var text = jQuery('#cmtx_email_dialog_field_2').val();
						
						text = jQuery.trim(text);
						
						if (text != null && text != '') {
						
							var tag = '<?php echo CMTX_BB_CODE_TAG_EMAIL_2; ?>' + email + '<?php echo CMTX_BB_CODE_TAG_EMAIL_3; ?>' + text + '<?php echo CMTX_BB_CODE_TAG_EMAIL_4; ?>';
							cmtx_add_tags('', tag);
						
						} else {
					
							var tag = '<?php echo CMTX_BB_CODE_TAG_EMAIL_1; ?>' + email + '<?php echo CMTX_BB_CODE_TAG_EMAIL_4; ?>';
							cmtx_add_tags('', tag);
						
						}
					
					}
					
					jQuery('#cmtx_email_dialog_field_1').val('');
					jQuery('#cmtx_email_dialog_field_2').val('');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_EMAIL_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_email_dialog_field_1').val('');
					jQuery('#cmtx_email_dialog_field_2').val('');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_email_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_image')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_image').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_image_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_IMAGE_DIALOG_INSERT); ?>': function() {

					var image = jQuery('#cmtx_image_dialog_field').val();
					
					image = jQuery.trim(image);
					
					if (image != null && image != '' && image != 'http://') {
					
						var tag = '<?php echo CMTX_BB_CODE_TAG_IMAGE_1; ?>' + image + '<?php echo CMTX_BB_CODE_TAG_IMAGE_2; ?>';
						cmtx_add_tags('', tag);
					
					}
					
					jQuery('#cmtx_image_dialog_field').val('http://');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_IMAGE_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_image_dialog_field').val('http://');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_image_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_video')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('#cmtx_bb_code_video').click(function(e) {

		e.preventDefault();

		jQuery('#cmtx_video_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_VIDEO_DIALOG_INSERT); ?>': function() {

					var video = jQuery('#cmtx_video_dialog_field').val();
					
					video = jQuery.trim(video);
					
					if (video != null && video != '' && video != 'http://') {
					
						var tag = '<?php echo CMTX_BB_CODE_TAG_VIDEO_1; ?>' + video + '<?php echo CMTX_BB_CODE_TAG_VIDEO_2; ?>';
						cmtx_add_tags('', tag);
					
					}
					
					jQuery('#cmtx_video_dialog_field').val('http://');
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_VIDEO_DIALOG_CANCEL); ?>': function() {
					jQuery('#cmtx_video_dialog_field').val('http://');
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_video_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<script type="text/javascript">
// <![CDATA[
function cmtx_enable_submit() {

	var frm = document.forms['commentics'];

	<?php if (cmtx_setting('enabled_terms') && !cmtx_setting('enabled_privacy')) { ?>
	if (frm.cmtx_terms.checked) {
		frm.cmtx_submit.disabled = false;
	} else {
		frm.cmtx_submit.disabled = true;
	}
	<?php } else if (!cmtx_setting('enabled_terms') && cmtx_setting('enabled_privacy')) { ?>
	if (frm.cmtx_privacy.checked) {
		frm.cmtx_submit.disabled = false;
	} else {
		frm.cmtx_submit.disabled = true;
	}
	<?php } else if (cmtx_setting('enabled_terms') && cmtx_setting('enabled_privacy')) { ?>
	if ( (frm.cmtx_terms.checked) && (frm.cmtx_privacy.checked) ) {
		frm.cmtx_submit.disabled = false;
	} else {
		frm.cmtx_submit.disabled = true;
	}
	<?php } ?>

}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function cmtx_enable_preview() {

	var frm = document.forms['commentics'];

	<?php if (cmtx_setting('enabled_preview') && cmtx_setting('agree_to_preview')) { ?>

	<?php if (cmtx_setting('enabled_terms') && !cmtx_setting('enabled_privacy')) { ?>
	if (frm.cmtx_terms.checked) {
		frm.cmtx_preview.disabled = false;
	} else {
		frm.cmtx_preview.disabled = true;
	}
	<?php } else if (!cmtx_setting('enabled_terms') && cmtx_setting('enabled_privacy')) { ?>
	if (frm.cmtx_privacy.checked) {
		frm.cmtx_preview.disabled = false;
	} else {
		frm.cmtx_preview.disabled = true;
	}
	<?php } else if (cmtx_setting('enabled_terms') && cmtx_setting('enabled_privacy')) { ?>
	if ( (frm.cmtx_terms.checked) && (frm.cmtx_privacy.checked) ) {
		frm.cmtx_preview.disabled = false;
	} else {
		frm.cmtx_preview.disabled = true;
	}
	<?php } ?>

	<?php } ?>

}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function cmtx_disable_enter_key(e) {
	var key;
	if (window.event) {
		key = window.event.keyCode; //IE
	} else {
		key = e.which; //Firefox
	}
	return (key != 13);
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function cmtx_process_preview() {

	var frm = document.forms['commentics'];

	frm.cmtx_submit.disabled = true;
	frm.cmtx_submit.value = '<?php echo cmtx_escape_js(CMTX_PROCESSING_BUTTON) ?>';

	frm.cmtx_preview.disabled = true;
	frm.cmtx_preview.value = '<?php echo cmtx_escape_js(CMTX_PROCESSING_BUTTON) ?>';

	frm.cmtx_sub_def.name = 'cmtx_sub';
	frm.cmtx_prev_def.name = 'cmtx_prev';

	document.commentics.submit();

	return true;

}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function cmtx_process_submit() {

	var frm = document.forms['commentics'];

	frm.cmtx_submit.disabled = true;
	frm.cmtx_submit.value = '<?php echo cmtx_escape_js(CMTX_PROCESSING_BUTTON) ?>';

	<?php if (cmtx_setting('enabled_preview')) { ?>
	frm.cmtx_preview.disabled = true;
	frm.cmtx_preview.value = '<?php echo cmtx_escape_js(CMTX_PROCESSING_BUTTON) ?>';
	<?php } ?>

	frm.cmtx_sub_def.name = 'cmtx_sub';

	document.commentics.submit();

	return true;

}
// ]]>
</script>

<?php if (cmtx_setting('hide_form')) { ?>
<script type="text/javascript">
// <![CDATA[
function cmtx_open_form() {
	document.getElementById("cmtx_open_form").style.display = 'none';
	document.getElementById("cmtx_hide_form").style.display = 'inline';
}
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_captcha') && cmtx_setting('captcha_type') == 'recaptcha') { ?>
<script type="text/javascript">
// <![CDATA[
var RecaptchaOptions = {
	lang : '<?php echo cmtx_setting('recaptcha_language'); ?>',
	theme : '<?php echo cmtx_setting('recaptcha_theme'); ?>'
};
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('enabled_privacy') || cmtx_setting('enabled_terms')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {
	jQuery('.cmtx_privacy_link').colorbox();
	jQuery('.cmtx_terms_link').colorbox();
});
// ]]>
</script>
<?php } ?>

<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {
	jQuery('.cmtx_approval_box').delay(2000).fadeOut(2000);
	jQuery('.cmtx_success_box').delay(2000).fadeOut(2000);
});
// ]]>
</script>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_bullet')) { ?>
<div id="cmtx_bullet_dialog" title="<?php echo CMTX_BULLET_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_1; ?>
		<div style="margin-top:10px;"></div>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_bullet_dialog_field_1" id="cmtx_bullet_dialog_field_1" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_bullet_dialog_field_2" id="cmtx_bullet_dialog_field_2" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_bullet_dialog_field_3" id="cmtx_bullet_dialog_field_3" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_bullet_dialog_field_4" id="cmtx_bullet_dialog_field_4" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_BULLET_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_bullet_dialog_field_5" id="cmtx_bullet_dialog_field_5" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_numeric')) { ?>
<div id="cmtx_numeric_dialog" title="<?php echo CMTX_NUMERIC_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_1; ?>
		<div style="margin-top:10px;"></div>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_numeric_dialog_field_1" id="cmtx_numeric_dialog_field_1" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_numeric_dialog_field_2" id="cmtx_numeric_dialog_field_2" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_numeric_dialog_field_3" id="cmtx_numeric_dialog_field_3" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_numeric_dialog_field_4" id="cmtx_numeric_dialog_field_4" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
		<br/>
		<?php echo CMTX_NUMERIC_DIALOG_CONTENT_2; ?> <input type="text" name="cmtx_numeric_dialog_field_5" id="cmtx_numeric_dialog_field_5" style="width:250px;" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_link')) { ?>
<div id="cmtx_link_dialog" title="<?php echo CMTX_LINK_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_LINK_DIALOG_CONTENT_1; ?>
		<br/>
		<input type="text" name="cmtx_link_dialog_field_1" id="cmtx_link_dialog_field_1" style="width:235px;" value="http://" class="text ui-widget-content ui-corner-all"/>
		<div style="margin-top:15px;"></div>
		<?php echo CMTX_LINK_DIALOG_CONTENT_2; ?>
		<br/>
		<input type="text" name="cmtx_link_dialog_field_2" id="cmtx_link_dialog_field_2" style="width:235px;" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_email')) { ?>
<div id="cmtx_email_dialog" title="<?php echo CMTX_EMAIL_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_EMAIL_DIALOG_CONTENT_1; ?>
		<br/>
		<input type="text" name="cmtx_email_dialog_field_1" id="cmtx_email_dialog_field_1" style="width:205px;" class="text ui-widget-content ui-corner-all"/>
		<div style="margin-top:15px;"></div>
		<?php echo CMTX_EMAIL_DIALOG_CONTENT_2; ?>
		<br/>
		<input type="text" name="cmtx_email_dialog_field_2" id="cmtx_email_dialog_field_2" style="width:205px;" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_image')) { ?>
<div id="cmtx_image_dialog" title="<?php echo CMTX_IMAGE_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_IMAGE_DIALOG_CONTENT; ?>
		<br/>
		<input type="text" name="cmtx_image_dialog_field" id="cmtx_image_dialog_field" style="width:222px;" value="http://" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_bb_code_video')) { ?>
<div id="cmtx_video_dialog" title="<?php echo CMTX_VIDEO_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<form>
		<?php echo CMTX_VIDEO_DIALOG_CONTENT_1; ?>
		<br/>
		<?php echo CMTX_VIDEO_DIALOG_CONTENT_2; ?>
		<br/>
		<input type="text" name="cmtx_video_dialog_field" id="cmtx_video_dialog_field" style="width:289px;" value="http://" class="text ui-widget-content ui-corner-all"/>
	</form>
	</div>
</div>
<?php } ?>

<h3 class="cmtx_form_heading" id="<?php echo str_ireplace('#', '', CMTX_ANCHOR_FORM); ?>"><?php echo CMTX_FORM_HEADING; ?></h3>

<div class="cmtx_height_below_form_heading"></div>

<?php
if (!cmtx_is_form_enabled(true)) { //if form is disabled
	return; //exit file
}
?>

<?php cmtx_clean_form_defaults(); ?>

<?php if (cmtx_setting('hide_form')) { ?>
<div id="cmtx_open_form" class="cmtx_open_form">
<a href="<?php echo cmtx_url_encode(cmtx_current_page()); ?>" title="<?php echo CMTX_OPEN_FORM_TITLE; ?>" onclick="cmtx_open_form();return false;"><?php echo CMTX_OPEN_FORM; ?></a>
</div>
<?php } ?>

<?php if (cmtx_setting('hide_form')) { ?>
<div id="cmtx_hide_form" style="display:none;">
<?php } ?>

<?php
if (isset($cmtx_box) && !empty($cmtx_box)) { //if a box exists
	echo $cmtx_box; //display box
}
?>

<form name="commentics" id="commentics" class="cmtx_form" action="<?php echo cmtx_url_encode(strtok(cmtx_current_page(), '?') . cmtx_get_query('form') . CMTX_ANCHOR_FORM); ?>" method="post">

<noscript>
<?php if (cmtx_setting('display_javascript_disabled')) { ?>
<div class="cmtx_javascript_disabled_message">
<?php echo CMTX_JAVASCRIPT_DISABLED; ?>
</div>
<div style="clear: left;"></div>
<?php } ?>
</noscript>

<?php if (cmtx_setting('show_reply')) { ?>
<div id="cmtx_hide_reply" style="display:none">
<?php if (!isset($cmtx_reply_id) || (isset($cmtx_reply_id) && !ctype_digit($cmtx_reply_id))) { $cmtx_reply_id = 0; } ?>
<input type="hidden" name="cmtx_reply_id" id="cmtx_reply_id" value="<?php echo $cmtx_reply_id; ?>"/>
<div class="cmtx_reply_bar">
<span id="cmtx_reply_message" class="cmtx_reply_message"></span>
<a href="<?php echo cmtx_url_encode(cmtx_current_page()); ?>" id="cmtx_reset_reply" class="cmtx_reset_reply" title="<?php echo CMTX_REPLY_CANCEL_TITLE; ?>" onclick="this.style.display='none'; document.getElementById('cmtx_reply_id').value='0'; document.getElementById('cmtx_reply_message').innerHTML='<?php echo CMTX_REPLY_NOBODY; ?>'; return false;"><?php echo CMTX_REPLY_CANCEL; ?></a>
</div>
<div style="clear: left;"></div>
<div class="cmtx_height_below_reply_bar"></div>
</div>
<?php } ?>

<?php if (cmtx_setting('display_required_symbol_message') && cmtx_setting('display_required_symbol')) {
?><span class="cmtx_required_symbol_message"><?php echo CMTX_REQUIRED_SYMBOL_MESSAGE; ?></span>
<div class="cmtx_height_below_required_symbol_message"></div>
<?php } ?>

<?php //get the security key and add to form as hidden input ?>
<input type="hidden" name="cmtx_security_key" value="<?php echo cmtx_setting('security_key'); ?>"/>

<?php //add a random token to help prevent refresh and back-button submission ?>
<input type="hidden" name="cmtx_resubmit_key" value="<?php echo cmtx_get_random_key(20); ?>"/>

<?php if (cmtx_setting('check_honeypot')) { //a normal input, hidden by CSS, which should never contain a value ?>
<input type="text" name="cmtx_honeypot" value="" style="display:none;" autocomplete="off"/>
<?php } ?>

<?php if (cmtx_setting('check_time')) { //get the time and add to form as hidden input ?>
<input type="hidden" name="cmtx_time" value="<?php echo time(); ?>"/>
<?php } ?>

<?php //these are hidden fields that are used as a workaround for preventing double submissions ?>
<input type="hidden" name="cmtx_sub_def" value=""/>
<input type="hidden" name="cmtx_prev_def" value=""/>

<?php function cmtx_output_name () { ?>
<?php global $cmtx_default_name, $cmtx_set_name_value; ?>
<?php if (isset($cmtx_set_name_value) && !empty($cmtx_set_name_value) && cmtx_setting('state_name') == 'hide') {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_NAME; ?>
<?php if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<input type="text" name="cmtx_name" class="cmtx_field cmtx_text_field cmtx_name_field" title="<?php echo CMTX_TITLE_NAME; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_NAME; ?>" maxlength="<?php echo cmtx_setting('field_maximum_name'); ?>" value="<?php echo $cmtx_default_name; ?>" <?php if (isset($cmtx_set_name_value) && !empty($cmtx_set_name_value) && cmtx_setting('state_name') == 'disable') { echo 'disabled="disabled"'; } ?> onkeypress="return cmtx_disable_enter_key(event)"/>
<?php } } ?>

<?php function cmtx_output_email () { ?>
<?php global $cmtx_default_email, $cmtx_set_email_value; ?>
<?php if (cmtx_setting('enabled_email')) { ?>
<?php if (isset($cmtx_set_email_value) && !empty($cmtx_set_email_value) && cmtx_setting('state_email') == 'hide') {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_EMAIL; ?>
<?php if (cmtx_setting('required_email') && cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<input type="text" name="cmtx_email" class="cmtx_field cmtx_text_field cmtx_email_field" title="<?php echo CMTX_TITLE_EMAIL; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_EMAIL; ?>" maxlength="<?php echo cmtx_setting('field_maximum_email'); ?>" value="<?php echo $cmtx_default_email; ?>" <?php if (isset($cmtx_set_email_value) && !empty($cmtx_set_email_value) && cmtx_setting('state_email') == 'disable') { echo 'disabled="disabled"'; } ?> onkeypress="return cmtx_disable_enter_key(event)"/>
<?php if (cmtx_setting('display_email_note')) { ?> <span class="cmtx_email_note"><?php echo CMTX_NOTE_EMAIL; ?></span> <?php } ?>
<?php } } } ?>

<?php function cmtx_output_website () { ?>
<?php global $cmtx_default_website, $cmtx_set_website_value; ?>
<?php if (cmtx_setting('enabled_website')) { ?>
<?php if (isset($cmtx_set_website_value) && !empty($cmtx_set_website_value) && cmtx_setting('state_website') == 'hide') {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_WEBSITE; ?>
<?php if (cmtx_setting('required_website') && cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<input type="text" name="cmtx_website" class="cmtx_field cmtx_text_field cmtx_website_field" title="<?php echo CMTX_TITLE_WEBSITE; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_WEBSITE; ?>" maxlength="<?php echo cmtx_setting('field_maximum_website'); ?>" value="<?php echo $cmtx_default_website; ?>" <?php if (isset($cmtx_set_website_value) && !empty($cmtx_set_website_value) && cmtx_setting('state_website') == 'disable') { echo 'disabled="disabled"'; } ?> onkeypress="return cmtx_disable_enter_key(event)"/>
<?php } } } ?>

<?php function cmtx_output_town () { ?>
<?php global $cmtx_default_town, $cmtx_set_town_value; ?>
<?php if (cmtx_setting('enabled_town')) { ?>
<?php if (isset($cmtx_set_town_value) && !empty($cmtx_set_town_value) && cmtx_setting('state_town') == 'hide') {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_TOWN; ?>
<?php if (cmtx_setting('required_town') && cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<input type="text" name="cmtx_town" class="cmtx_field cmtx_text_field cmtx_town_field" title="<?php echo CMTX_TITLE_TOWN; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_TOWN; ?>" maxlength="<?php echo cmtx_setting('field_maximum_town'); ?>" value="<?php echo $cmtx_default_town; ?>" <?php if (isset($cmtx_set_town_value) && !empty($cmtx_set_town_value) && cmtx_setting('state_town') == 'disable') { echo 'disabled="disabled"'; } ?> onkeypress="return cmtx_disable_enter_key(event)"/>
<?php } } } ?>

<?php function cmtx_output_country () { ?>
<?php global $cmtx_default_country, $cmtx_set_country_value, $cmtx_path; ?>
<?php if (cmtx_setting('enabled_country')) { ?>
<?php if (isset($cmtx_set_country_value) && !empty($cmtx_set_country_value) && cmtx_setting('state_country') == 'hide') {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_COUNTRY; ?>
<?php if (cmtx_setting('required_country') && cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<?php
require_once $cmtx_path . 'includes/template/countries.php';
if (!empty($cmtx_default_country)) {
	$cmtx_countries = str_ireplace('"'.$cmtx_default_country.'"', '"'.$cmtx_default_country.'" selected="selected"', $cmtx_countries);
}
if (isset($cmtx_set_country_value) && !empty($cmtx_set_country_value) && cmtx_setting('state_country') == 'disable') {
	$cmtx_countries = str_ireplace('name="cmtx_country"', 'name="cmtx_country" disabled="disabled"', $cmtx_countries);
}
echo $cmtx_countries;
?>
<?php } } } ?>

<?php function cmtx_output_rating () { ?>
<?php global $cmtx_default_rating, $cmtx_path; ?>
<?php if (cmtx_setting('enabled_rating')) { ?>
<?php if (cmtx_setting('repeat_ratings') == 'hide' && cmtx_has_rated_form()) {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_RATING; ?>
<?php if (cmtx_setting('required_rating') && cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<?php
require_once $cmtx_path . 'includes/template/ratings.php';
if (cmtx_setting('repeat_ratings') == 'disable' && cmtx_has_rated_form()) {
	$cmtx_ratings = $cmtx_rated;
} else {
	if (!empty($cmtx_default_rating)) {
		$cmtx_ratings = str_ireplace('"'.$cmtx_default_rating.'"', '"'.$cmtx_default_rating.'" selected="selected"', $cmtx_ratings);
	}
}
echo $cmtx_ratings;
?>
<?php } } } ?>

<?php
$cmtx_elements = explode(',', cmtx_setting('sort_order_fields'));
foreach ($cmtx_elements as $cmtx_element) {
	switch ($cmtx_element) {
		case '1':
		cmtx_output_name();
		break;
		case '2':
		cmtx_output_email();
		break;
		case '3':
		cmtx_output_website();
		break;
		case '4':
		cmtx_output_town();
		break;
		case '5':
		cmtx_output_country();
		break;
		case '6':
		cmtx_output_rating();
		break;
	}
}
?>

<?php if (cmtx_setting('enabled_bb_code') || cmtx_setting('enabled_smilies')) { ?>
<div class="cmtx_height_above_bb_and_smilies"></div>
<?php } else { ?>
<div class="cmtx_height_between_fields"></div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<div class="cmtx_bb_code_block">
<?php if (cmtx_setting('enabled_bb_code_bold')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/bold.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_BOLD; ?>" alt="Bold" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_BOLD_1; ?>', '<?php echo CMTX_BB_CODE_TAG_BOLD_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_italic')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/italic.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_ITALIC; ?>" alt="Italic" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_ITALIC_1; ?>', '<?php echo CMTX_BB_CODE_TAG_ITALIC_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_underline')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/underline.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_UNDERLINE; ?>" alt="Underline" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_UNDERLINE_1; ?>', '<?php echo CMTX_BB_CODE_TAG_UNDERLINE_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_strike')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/strike.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_STRIKE; ?>" alt="Strike" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_STRIKE_1; ?>', '<?php echo CMTX_BB_CODE_TAG_STRIKE_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_superscript')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/superscript.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_SUPERSCRIPT; ?>" alt="Superscript" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_SUPERSCRIPT_1; ?>', '<?php echo CMTX_BB_CODE_TAG_SUPERSCRIPT_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_subscript')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/subscript.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_SUBSCRIPT; ?>" alt="Subscript" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_SUBSCRIPT_1; ?>', '<?php echo CMTX_BB_CODE_TAG_SUBSCRIPT_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_code')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/code.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_CODE; ?>" alt="Code" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_CODE_1; ?>', '<?php echo CMTX_BB_CODE_TAG_CODE_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_php')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/php.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_PHP; ?>" alt="PHP" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_PHP_1; ?>', '<?php echo CMTX_BB_CODE_TAG_PHP_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_quote')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/quote.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_QUOTE; ?>" alt="Quote" class="cmtx_bb_code_image" onclick="cmtx_add_tags('<?php echo CMTX_BB_CODE_TAG_QUOTE_1; ?>', '<?php echo CMTX_BB_CODE_TAG_QUOTE_2; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_line')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/line.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_LINE; ?>" alt="Line" class="cmtx_bb_code_image" onclick="cmtx_add_tags('', '<?php echo CMTX_BB_CODE_TAG_LINE; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_bullet')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/bullet.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_BULLET; ?>" alt="Bullet" class="cmtx_bb_code_image" id="cmtx_bb_code_bullet"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_numeric')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/numeric.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_NUMERIC; ?>" alt="Numeric" class="cmtx_bb_code_image" id="cmtx_bb_code_numeric"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_link')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/link.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_LINK; ?>" alt="Link" class="cmtx_bb_code_image" id="cmtx_bb_code_link"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_email')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/email.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_EMAIL; ?>" alt="Email" class="cmtx_bb_code_image" id="cmtx_bb_code_email"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_image')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/image.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_IMAGE; ?>" alt="Image" class="cmtx_bb_code_image" id="cmtx_bb_code_image"/>
<?php } ?>
<?php if (cmtx_setting('enabled_bb_code_video')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/bb_code/video.png'; ?>" title="<?php echo CMTX_BB_CODE_TITLE_VIDEO; ?>" alt="Video" class="cmtx_bb_code_image" id="cmtx_bb_code_video"/>
<?php } ?>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') && cmtx_setting('enabled_smilies')) { ?>
<div class="cmtx_height_between_bb_and_smilies"></div>
<?php } ?>

<?php if (cmtx_setting('enabled_smilies')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<div class="cmtx_smilies_block">
<?php if (cmtx_setting('enabled_smilies_smile')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/smile.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_SMILE; ?>" alt="Smile" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_SMILE; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_sad')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/sad.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_SAD; ?>" alt="Sad" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_SAD; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_huh')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/huh.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_HUH; ?>" alt="Huh" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_HUH; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_laugh')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/laugh.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_LAUGH; ?>" alt="Laugh" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_LAUGH; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_mad')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/mad.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_MAD; ?>" alt="Mad" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_MAD; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_tongue')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/tongue.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_TONGUE; ?>" alt="Tongue" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_TONGUE; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_crying')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/crying.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_CRYING; ?>" alt="Crying" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_CRYING; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_grin')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/grin.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_GRIN; ?>" alt="Grin" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_GRIN; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_wink')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/wink.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_WINK; ?>" alt="Wink" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_WINK; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_scared')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/scared.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_SCARED; ?>" alt="Scared" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_SCARED; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_cool')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/cool.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_COOL; ?>" alt="Cool" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_COOL; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_sleep')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/sleep.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_SLEEP; ?>" alt="Sleep" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_SLEEP; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_blush')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/blush.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_BLUSH; ?>" alt="Blush" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_BLUSH; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_unsure')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/unsure.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_UNSURE; ?>" alt="Unsure" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_UNSURE; ?>')"/>
<?php } ?>
<?php if (cmtx_setting('enabled_smilies_shocked')) { ?>
<img src="<?php echo cmtx_commentics_url() . 'images/smilies/shocked.gif'; ?>" title="<?php echo CMTX_SMILEY_TITLE_SHOCKED; ?>" alt="Shocked" class="cmtx_smiley_image" onclick="cmtx_add_tags('', '<?php echo CMTX_SMILEY_TAG_SHOCKED; ?>')"/>
<?php } ?>
</div>
<?php } ?>

<?php if (cmtx_setting('enabled_bb_code') || cmtx_setting('enabled_smilies')) { ?>
<div class="cmtx_height_below_bb_and_smilies"></div>
<?php } ?>

<label class="cmtx_label">
<?php echo CMTX_LABEL_COMMENT; ?>
<?php if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<textarea name="cmtx_comment" class="cmtx_field cmtx_textarea_field cmtx_comment_field" title="<?php echo CMTX_TITLE_COMMENT; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_COMMENT; ?>" maxlength="<?php echo cmtx_setting('comment_maximum_characters'); ?>" onkeyup="cmtx_text_counter()" onkeydown="cmtx_text_counter()"><?php echo $cmtx_default_comment; ?></textarea>

<div style="clear: left;"></div>

<?php if (cmtx_setting('enabled_counter')) { ?>
<div class="cmtx_label">&nbsp;</div>
<span class="cmtx_counter_text">
<?php printf(CMTX_TEXT_COUNTER, '<span id="cmtx_counter" class="cmtx_counter">' . cmtx_setting('comment_maximum_characters') . '</span>'); ?>
</span>
<?php } ?>

<?php function cmtx_output_question () { ?>
<?php if (cmtx_setting('enabled_question')) { ?>
<?php if (cmtx_session_set() && isset($_SESSION['cmtx_question']) && $_SESSION['cmtx_question'] == cmtx_setting('session_key')) {} else { ?>
<div class="cmtx_height_between_fields"></div>
<label class="cmtx_label">
<?php echo CMTX_LABEL_QUESTION; ?>
<?php if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
</label>
<?php $cmtx_question = cmtx_get_question(); ?>
<span class="cmtx_question_part_question_text"><?php echo $cmtx_question[0]; ?></span>
<input type="hidden" name="cmtx_real_answer" value="<?php echo $cmtx_question[1]; ?>"/>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<span class="cmtx_question_part_answer_text"><?php echo CMTX_TEXT_QUESTION; ?></span>
<input type="text" name="cmtx_user_answer" class="cmtx_field cmtx_text_field cmtx_question_field" title="<?php echo CMTX_TITLE_QUESTION; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_QUESTION; ?>" maxlength="<?php echo cmtx_setting('field_maximum_question'); ?>" onkeypress="return cmtx_disable_enter_key(event)"/>
<?php } } } ?>

<?php
function cmtx_output_captcha () {
	global $cmtx_path;
	if (cmtx_session_set() && isset($_SESSION['cmtx_captcha']) && $_SESSION['cmtx_captcha'] == cmtx_setting('session_key')) {} else {
		if (cmtx_setting('enabled_captcha') && cmtx_setting('captcha_type') == 'securimage' && extension_loaded('gd') && function_exists('imagettftext')) {
			?><div class="cmtx_height_between_fields"></div>
			<label class="cmtx_label"><?php
			echo CMTX_LABEL_CAPTCHA;
			if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
			</label>
			<img id="cmtx_securimage" class="cmtx_securimage" src="<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_show.php" alt="Captcha" title="Captcha"/>
			<object type="application/x-shockwave-flash" wmode="transparent" data="<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_play.swf?audio_file=<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_play.php&amp;icon_file=<?php echo cmtx_commentics_url(); ?>external/securimage/images/audio_icon.png" title="<?php echo CMTX_TITLE_SECURIMAGE_AUDIO; ?>" class="cmtx_securimage_audio_icon">
			<param name="movie" value="<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_play.swf?audio_file=<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_play.php&amp;icon_file=<?php echo cmtx_commentics_url(); ?>external/securimage/images/audio_icon.png"/>
			</object>
			<br/>
			<a href="<?php echo cmtx_url_encode(cmtx_current_page()); ?>" onclick="document.getElementById('cmtx_securimage').src = '<?php echo cmtx_commentics_url(); ?>external/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?php echo cmtx_commentics_url(); ?>external/securimage/images/refresh_icon.png" alt="Refresh" title="<?php echo CMTX_TITLE_SECURIMAGE_REFRESH; ?>" class="cmtx_securimage_refresh_icon"/></a>
			<div style="clear: left;"></div>
			<div class="cmtx_label">&nbsp;</div>
			<span class="securimage_text"><?php echo CMTX_TEXT_SECURIMAGE; ?></span>
			<input type="text" name="cmtx_captcha_code" class="cmtx_field cmtx_text_field cmtx_securimage_field" title="<?php echo CMTX_TITLE_SECURIMAGE; ?>" placeholder="<?php echo CMTX_PLACEHOLDER_CAPTCHA; ?>" maxlength="<?php echo cmtx_setting('field_maximum_captcha'); ?>" onkeypress="return cmtx_disable_enter_key(event)"/>
			<?php
		} else if (cmtx_setting('enabled_captcha') && cmtx_setting('captcha_type') == 'recaptcha' && function_exists('fsockopen') && is_callable('fsockopen')) {
			?><div class="cmtx_height_between_fields"></div>
			<label class="cmtx_label"><?php
			echo CMTX_LABEL_CAPTCHA;
			if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
			</label>
			<div class="cmtx_recaptcha"><?php
			if ((cmtx_setting('recaptcha_public_key') == '') || (cmtx_setting('recaptcha_private_key') == '')) {
				echo '<span class="cmtx_recaptcha_no_key">' . CMTX_RECAPTCHA_NO_KEY . '</span>.';
			} else {
				require_once $cmtx_path . 'includes/external/recaptcha/recaptchalib.php';
				$cmtx_recaptcha_public_key = cmtx_setting('recaptcha_public_key');
				echo recaptcha_get_html($cmtx_recaptcha_public_key);
			} ?>
			</div>
			<div style="clear: left;"></div><?php
		}
	}
}
?>

<?php
$cmtx_elements = explode(',', cmtx_setting('sort_order_captchas'));
foreach ($cmtx_elements as $cmtx_element) {
	switch ($cmtx_element) {
		case '1':
		cmtx_output_question();
		break;
		case '2':
		cmtx_output_captcha();
		break;
	}
}
?>

<?php if ( (cmtx_setting('enabled_notify') && cmtx_setting('enabled_email')) || (cmtx_setting('enabled_remember')) || (cmtx_setting('enabled_privacy')) || (cmtx_setting('enabled_terms')) ) { ?>
<div class="cmtx_height_above_checkboxes"></div>
<?php } ?>

<?php function cmtx_output_notify () { ?>
<?php global $cmtx_default_notify; ?>
<?php if (cmtx_setting('enabled_notify') && cmtx_setting('enabled_email')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<?php if ($cmtx_default_notify) { ?>
<input type="checkbox" name="cmtx_notify" class="cmtx_checkbox_field cmtx_notify_field" title="<?php echo CMTX_TITLE_NOTIFY; ?>" checked="checked"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_notify" class="cmtx_checkbox_field cmtx_notify_field" title="<?php echo CMTX_TITLE_NOTIFY; ?>"/>
<?php } ?>
<span class="cmtx_notify_text"><?php echo CMTX_TEXT_NOTIFY; ?></span>
<?php } } ?>

<?php function cmtx_output_remember () { ?>
<?php global $cmtx_default_remember; ?>
<?php if (cmtx_setting('enabled_remember')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<?php if ($cmtx_default_remember) { ?>
<input type="checkbox" name="cmtx_remember" class="cmtx_checkbox_field cmtx_remember_field" title="<?php echo CMTX_TITLE_REMEMBER; ?>" checked="checked"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_remember" class="cmtx_checkbox_field cmtx_remember_field" title="<?php echo CMTX_TITLE_REMEMBER; ?>"/>
<?php } ?>
<span class="cmtx_remember_text"><?php echo CMTX_TEXT_REMEMBER; ?></span>
<?php } } ?>

<?php function cmtx_output_privacy () { ?>
<?php global $cmtx_default_privacy, $cmtx_path; ?>
<?php if (cmtx_setting('enabled_privacy')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<?php if ($cmtx_default_privacy) { ?>
<input type="checkbox" name="cmtx_privacy" class="cmtx_checkbox_field cmtx_privacy_field" title="<?php echo CMTX_TITLE_PRIVACY; ?>" checked="checked" onclick="cmtx_enable_submit(); cmtx_enable_preview();"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_privacy" class="cmtx_checkbox_field cmtx_privacy_field" title="<?php echo CMTX_TITLE_PRIVACY; ?>" onclick="cmtx_enable_submit();cmtx_enable_preview();"/>
<?php } ?>
<?php
if (file_exists($cmtx_path . 'agreement/' . cmtx_setting('language_frontend') . '/custom/privacy_policy.html')) {
	$privacy_link = '<a href="' . cmtx_commentics_url() . 'agreement/' . cmtx_setting('language_frontend') . '/custom/privacy_policy.html" class="cmtx_privacy_link" title="' . CMTX_PRIVACY_LINK_TITLE . '" target="_blank" rel="nofollow">' . CMTX_PRIVACY_LINK . '</a>';
} else {
	$privacy_link = '<a href="' . cmtx_commentics_url() . 'agreement/' . cmtx_setting('language_frontend') . '/privacy_policy.html" class="cmtx_privacy_link" title="' . CMTX_PRIVACY_LINK_TITLE . '" target="_blank" rel="nofollow">' . CMTX_PRIVACY_LINK . '</a>';
}
?>
<span class="cmtx_privacy_text"><?php printf(CMTX_PRIVACY_TEXT, $privacy_link); ?></span>
<?php if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
<?php } } ?>

<?php function cmtx_output_terms () { ?>
<?php global $cmtx_default_terms, $cmtx_path; ?>
<?php if (cmtx_setting('enabled_terms')) { ?>
<div style="clear: left;"></div>
<div class="cmtx_label">&nbsp;</div>
<?php if ($cmtx_default_terms) { ?>
<input type="checkbox" name="cmtx_terms" class="cmtx_checkbox_field cmtx_terms_field" title="<?php echo CMTX_TITLE_TERMS; ?>" checked="checked" onclick="cmtx_enable_submit(); cmtx_enable_preview();"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_terms" class="cmtx_checkbox_field cmtx_terms_field" title="<?php echo CMTX_TITLE_TERMS; ?>" onclick="cmtx_enable_submit(); cmtx_enable_preview();"/>
<?php } ?>
<?php
if (file_exists($cmtx_path . 'agreement/' . cmtx_setting('language_frontend') . '/custom/terms_and_conditions.html')) {
	$terms_link = '<a href="' . cmtx_commentics_url() . 'agreement/' . cmtx_setting('language_frontend') . '/custom/terms_and_conditions.html" class="cmtx_terms_link" title="' . CMTX_TERMS_LINK_TITLE . '" target="_blank" rel="nofollow">' . CMTX_TERMS_LINK . '</a>';
} else {
	$terms_link = '<a href="' . cmtx_commentics_url() . 'agreement/' . cmtx_setting('language_frontend') . '/terms_and_conditions.html" class="cmtx_terms_link" title="' . CMTX_TERMS_LINK_TITLE . '" target="_blank" rel="nofollow">' . CMTX_TERMS_LINK . '</a>';
}
?>
<span class="cmtx_terms_text"><?php printf(CMTX_TERMS_TEXT, $terms_link); ?></span>
<?php if (cmtx_setting('display_required_symbol')) { ?><span class="cmtx_required_symbol"><?php echo ' ' . CMTX_REQUIRED_SYMBOL; ?></span><?php } ?>
<?php } } ?>

<?php
$cmtx_elements = explode(',', cmtx_setting('sort_order_checkboxes'));
foreach ($cmtx_elements as $cmtx_element) {
	switch ($cmtx_element) {
		case '1':
		cmtx_output_notify();
		break;
		case '2':
		cmtx_output_remember();
		break;
		case '3':
		cmtx_output_privacy();
		break;
		case '4':
		cmtx_output_terms();
		break;
	}
}
?>

<div style="clear: left;"></div>
<div class="cmtx_height_above_buttons"></div>
<div class="cmtx_label">&nbsp;</div>

<?php if ($cmtx_is_admin) { $cmtx_admin_button = ' cmtx_admin_button'; } else { $cmtx_admin_button = ''; } ?>

<?php function cmtx_output_submit () { ?>
<?php global $cmtx_admin_button; ?>
<?php if (cmtx_setting('enabled_terms') || cmtx_setting('enabled_privacy')) { ?>
<input type="submit" class="cmtx_button cmtx_submit_button<?php echo $cmtx_admin_button; ?>" name="cmtx_submit" title="<?php echo CMTX_TITLE_SUBMIT; ?>" disabled="disabled" onclick="return cmtx_process_submit()" value="<?php echo CMTX_SUBMIT_BUTTON; ?>"/>
<?php } else { ?>
<input type="submit" class="cmtx_button cmtx_submit_button<?php echo $cmtx_admin_button; ?>" name="cmtx_submit" title="<?php echo CMTX_TITLE_SUBMIT; ?>" onclick="return cmtx_process_submit()" value="<?php echo CMTX_SUBMIT_BUTTON; ?>"/>
<?php } } ?>

<?php function cmtx_output_preview () { ?>
<?php global $cmtx_admin_button; ?>
<?php if (cmtx_setting('enabled_preview')) { ?>
<?php if ( (cmtx_setting('enabled_terms') || cmtx_setting('enabled_privacy')) && (cmtx_setting('agree_to_preview')) ) { ?>
<input type="submit" class="cmtx_button cmtx_preview_button<?php echo $cmtx_admin_button; ?>" name="cmtx_preview" disabled="disabled" title="<?php echo CMTX_TITLE_PREVIEW; ?>" onclick="return cmtx_process_preview();" value="<?php echo CMTX_PREVIEW_BUTTON; ?>"/>
<?php } else { ?>
<input type="submit" class="cmtx_button cmtx_preview_button<?php echo $cmtx_admin_button; ?>" name="cmtx_preview" title="<?php echo CMTX_TITLE_PREVIEW; ?>" onclick="return cmtx_process_preview();" value="<?php echo CMTX_PREVIEW_BUTTON; ?>"/>
<?php } } } ?>

<?php
$cmtx_elements = explode(',', cmtx_setting('sort_order_buttons'));
foreach ($cmtx_elements as $cmtx_element) {
	switch ($cmtx_element) {
		case '1':
		cmtx_output_submit();
		break;
		case '2':
		cmtx_output_preview();
		break;
	}
}
?>

<script type="text/javascript">cmtx_text_counter();</script>
<script type="text/javascript">cmtx_enable_submit();</script>
<script type="text/javascript">cmtx_enable_preview();</script>

</form>

<?php if (cmtx_setting('display_parsing') && $cmtx_is_admin) { ?>
<div style="clear: left;"></div>
<div class="cmtx_height_above_parsing"></div>
<div class="cmtx_label">&nbsp;</div>
<div class="cmtx_parsing_box">
<div id="cmtx_parsing" class="cmtx_parsing_text"></div>
</div>
<div style="clear: left;"></div>
<?php } ?>

<?php if (cmtx_setting('powered_by_new_window')) { $cmtx_powered_attribute = ' target="_blank"'; } else { $cmtx_powered_attribute = ''; } ?>
<?php if (cmtx_setting('powered_by') == 'image') { ?>
<div style="clear: left;"></div>
<div class="cmtx_height_above_powered"></div>
<div class="cmtx_label">&nbsp;</div>
<a href="http://www.commentics.org"<?php echo $cmtx_powered_attribute; ?>><img src="<?php echo cmtx_commentics_url() . "images/commentics/powered_by.png";?>" title="Commentics" alt="Commentics"/></a>
<?php } else if (cmtx_setting('powered_by') == 'text') { ?>
<div style="clear: left;"></div>
<div class="cmtx_height_above_powered"></div>
<div class="cmtx_label">&nbsp;</div>
<span class="cmtx_powered_by"><?php echo CMTX_POWERED_BY . ' '; ?><a href="http://www.commentics.org"<?php echo $cmtx_powered_attribute; ?> title="Commentics">Commentics</a></span>
<?php } ?>

<?php if (cmtx_setting('hide_form')) { ?>
</div>
<?php } ?>

<?php if (cmtx_setting('hide_form') && defined('CMTX_PROCESSING')) { ?>
<script type="text/javascript">cmtx_open_form();</script>
<?php } ?>