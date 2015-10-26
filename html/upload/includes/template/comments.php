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

<?php if (cmtx_setting('show_average_rating')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {
	jQuery('.cmtx_average_rating_stars').raty({
		cancel: false,
		half: false,
		halfShow: false,
		hints: ['<?php echo cmtx_escape_js(CMTX_RATING_ONE); ?>', '<?php echo cmtx_escape_js(CMTX_RATING_TWO); ?>', '<?php echo cmtx_escape_js(CMTX_RATING_THREE); ?>', '<?php echo cmtx_escape_js(CMTX_RATING_FOUR); ?>', '<?php echo cmtx_escape_js(CMTX_RATING_FIVE); ?>'],
		number: 5,
		numberMax: 5,
		path: '<?php echo cmtx_commentics_url() . 'images/stars/'?>',
		<?php if (cmtx_has_rated_comments()) { echo 'readOnly: true,'; } ?>
		score: <?php echo cmtx_average_rating(); ?>,
		scoreName: 'cmtx_score',
		single: false,
		size: 16,
		space: false,
		starOff: 'star_empty.png',
		starOn: 'star_full.png',
		width: false,
		click: function(rating, e) {
		
			jQuery.ajax({

				type: 'POST',
				url: '<?php echo cmtx_commentics_url() . 'rate.php'; ?>',
				data: {id: <?php echo $cmtx_page_id; ?>, rating: rating},
				cache: false,

				success: function(response) {
					if (response == '1' || response == '2' || response == '3' || response == '4' || response == '5') { //success
						jQuery('.cmtx_average_rating_stars').fadeOut(1000, function() { jQuery('.cmtx_average_rating_stars').raty('set', { score: response, readOnly: true }).fadeIn(1000); });
						jQuery('.cmtx_average_rating_text').fadeOut(1000, function() { jQuery('.cmtx_average_rating_text').text(response + '<?php echo '/5 (' . (cmtx_number_of_ratings() + 1) . ')'; ?>').fadeIn(1000); });
					} else { //error
						jQuery('.cmtx_error_ajax').clearQueue();
						jQuery('.cmtx_error_ajax').html(response);
						jQuery('.cmtx_error_ajax').css('top', e.pageY);
						jQuery('.cmtx_error_ajax').css('left', e.pageX);
						jQuery('.cmtx_error_ajax').fadeIn(500).delay(2000).fadeOut(500);
					}
				}

			});
			
		}
	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('show_reply') && cmtx_setting('scroll_reply')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('.cmtx_reply_enabled').click(function() {
	
		jQuery('html, body').animate({
			scrollTop: jQuery('#<?php echo str_ireplace('#', '', CMTX_ANCHOR_FORM); ?>').offset().top
		}, <?php echo cmtx_setting('scroll_speed'); ?>);
		
		return false;
		
	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('show_like') || cmtx_setting('show_dislike')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('.cmtx_vote').click(function(e) {

		e.preventDefault();

		var id = jQuery(this).attr('id');

		var parent = jQuery(this);

		if (id.indexOf('_like_') != -1) {
			var type = 'like';
		} else {
			var type = 'dislike';
		}

		jQuery.ajax({

			type: 'POST',
			url: '<?php echo cmtx_commentics_url() . 'vote.php'?>',
			data: {id: id, type: type},
			cache: false,

			success: function(response) {
				if (response.indexOf('<') != -1) { //success
					parent.html(response);
					if (type == 'like') {
						jQuery('#cmtx_flash_like_' + id.replace('cmtx_like_', '')).effect('highlight', {color: '#529214'}, 2000);
					} else {
						jQuery('#cmtx_flash_dislike_' + id.replace('cmtx_dislike_', '')).effect('highlight', {color: '#D12F19'}, 2000);
					}
				} else { //error
					jQuery('.cmtx_error_ajax').clearQueue();
					jQuery('.cmtx_error_ajax').html(response);
					jQuery('.cmtx_error_ajax').css('top', e.pageY);
					jQuery('.cmtx_error_ajax').css('left', e.pageX);
					jQuery('.cmtx_error_ajax').fadeIn(500).delay(2000).fadeOut(500);
				}
			}

		});

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('show_flag')) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {

	jQuery('.cmtx_flag').click(function(e) {

		e.preventDefault();
		
		var id = jQuery(this).attr('id');
		
		jQuery('#cmtx_flag_dialog').dialog({
			modal: true,
			height: 'auto',
			width: 'auto',
			resizable: false,
			draggable: false,
			center: true,
			buttons: {
				'<?php echo cmtx_escape_js(CMTX_FLAG_DIALOG_YES); ?>': function() {

					jQuery.ajax({
						type: 'POST',
						url: '<?php echo cmtx_commentics_url() . 'flag.php'?>',
						data: {id: id},
						cache: false,

						success: function(response) {
						
							if (response == '<?php echo cmtx_escape_js(CMTX_FLAG_REPORT_SENT); ?>') { //success
								jQuery('.cmtx_success_ajax').clearQueue();
								jQuery('.cmtx_success_ajax').html(response);
								jQuery('.cmtx_success_ajax').css('top', e.pageY);
								jQuery('.cmtx_success_ajax').css('left', e.pageX);
								jQuery('.cmtx_success_ajax').fadeIn(500).delay(3000).fadeOut(500);
							} else { //error
								jQuery('.cmtx_error_ajax').clearQueue();
								jQuery('.cmtx_error_ajax').html(response);
								jQuery('.cmtx_error_ajax').css('top', e.pageY);
								jQuery('.cmtx_error_ajax').css('left', e.pageX);
								jQuery('.cmtx_error_ajax').fadeIn(500).delay(3000).fadeOut(500);
							}
							
						}
					
					});
					
					jQuery(this).dialog('close');
					
				},
				'<?php echo cmtx_escape_js(CMTX_FLAG_DIALOG_NO); ?>': function() {
					jQuery(this).dialog('close');
				}
			}
		});

		jQuery('#cmtx_flag_dialog').dialog('open');

		return false;

	});
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('show_read_more')) { ?>
<script type="text/javascript">
// <![CDATA[
function cmtx_read_more(id) {
	document.getElementById('cmtx_comment_less_' + id).style.display = 'none';
	document.getElementById('cmtx_comment_more_' + id).style.display = 'inline';
}
// ]]>
</script>
<?php } ?>

<?php if (isset($_GET['cmtx_perm']) && ctype_digit($_GET['cmtx_perm'])) { ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {
	jQuery('#cmtx_perm_<?php echo $_GET['cmtx_perm']; ?>').effect('highlight', {color: '#FFFF99'}, 2000);
});
// ]]>
</script>
<?php } ?>

<?php if (cmtx_setting('show_flag')) { ?>
<div id="cmtx_flag_dialog" title="<?php echo CMTX_FLAG_DIALOG_HEADING; ?>" style="display:none;">
	<div style="margin-top:10px;">
	<?php echo CMTX_FLAG_DIALOG_CONTENT; ?>
	</div>
</div>
<?php } ?>

<div class="cmtx_success_ajax"></div>
<div class="cmtx_error_ajax"></div>

<?php
//Permalink (Calculation Only)
if (isset($_GET['cmtx_perm']) && ctype_digit($_GET['cmtx_perm'])) {

	global $cmtx_perm_counter;
	
	$cmtx_sort = cmtx_get_sort_by();
	
	$cmtx_comments_query = cmtx_db_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '0' AND `is_approved` = '1' AND `page_id` = '$cmtx_page_id' ORDER BY $cmtx_sort;");

	$cmtx_perm_counter = 0;
	$cmtx_exit_loop = false;

	while ($cmtx_comments = cmtx_db_fetch_assoc($cmtx_comments_query)) {

		cmtx_calc_permalink($cmtx_comments['id']);
		
		if ($cmtx_exit_loop) {
			break;
		}

	}
}
?>

<?php
//get number of approved comments for current page
$cmtx_number_of_comments = cmtx_number_of_comments();
?>

<h3 class="cmtx_comments_heading" id="<?php echo str_ireplace('#', '', CMTX_ANCHOR_COMMENTS); ?>"><?php echo CMTX_COMMENTS_HEADING; ?><?php if (cmtx_setting('show_comment_count') && $cmtx_number_of_comments) { ?> <span class="cmtx_comments_count"><?php echo '(' . $cmtx_number_of_comments . ')';?></span><?php } ?></h3>

<div class="cmtx_height_below_comments_heading"></div>

<?php
if ($cmtx_number_of_comments == 0) { //if no comments

	echo '<span class="cmtx_no_comments_text">';
	echo CMTX_NO_COMMENTS;
	echo '</span>';

} else { //if there are comments



	/* *** Topic *** */
	if (cmtx_setting('show_topic')) {

		if (isset($cmtx_set_topic) && !empty($cmtx_set_topic)) {
			$cmtx_topic = cmtx_sanitize($cmtx_set_topic, true, false);
		} else {
			$cmtx_topic = cmtx_get_page_reference();
		}

		if (cmtx_setting('rich_snippets') && cmtx_setting('show_average_rating') && cmtx_average_rating() != 0) {
		
			$cmtx_rich_snippets = true;
		
			if (cmtx_setting('rich_snippets_markup') == 'Microdata') {
				echo '<div itemscope="itemscope" itemtype="http://data-vocabulary.org/Review-aggregate">';
				echo '<div class="cmtx_topic_block">';
				echo '<span class="cmtx_topic_intro">' . CMTX_TOPIC_INTRO . '</span>: ';
				echo '<span class="cmtx_topic_page" itemprop="itemreviewed">' . $cmtx_topic . '</span>';
				echo '</div>';
			} else if (cmtx_setting('rich_snippets_markup') == 'Microformats') {
				echo '<div class="hreview-aggregate">';
				echo '<div class="cmtx_topic_block">';
				echo '<span class="cmtx_topic_intro">' . CMTX_TOPIC_INTRO . '</span>: ';
				echo '<span class="item"><span class="fn cmtx_topic_page">' . $cmtx_topic . '</span></span>';
				echo '</div>';
			} else if (cmtx_setting('rich_snippets_markup') == 'RDFa') {
				echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">';
				echo '<div class="cmtx_topic_block">';
				echo '<span class="cmtx_topic_intro">' . CMTX_TOPIC_INTRO . '</span>: ';
				echo '<span class="cmtx_topic_page" property="v:itemreviewed">' . $cmtx_topic . '</span>';
				echo '</div>';
			}
		
		} else {
			echo '<div class="cmtx_topic_block">';
			echo '<span class="cmtx_topic_intro">' . CMTX_TOPIC_INTRO . '</span>: ';
			echo '<span class="cmtx_topic_page">' . $cmtx_topic . '</span>';
			echo '</div>';
		}

	}


	
	/* *** Pagination (Calculation Only) *** */
	$cmtx_total_pages = ceil($cmtx_number_of_comments / cmtx_setting('comments_per_page'));

	if (isset($_GET['cmtx_page']) && ctype_digit($_GET['cmtx_page'])) {
		$cmtx_current_page = (int) $_GET['cmtx_page']; //get the current page
	} else {
		$cmtx_current_page = 1; //or set a default
	}

	if ($cmtx_current_page > $cmtx_total_pages) { //if current page is greater than total pages
	   $cmtx_current_page = $cmtx_total_pages; //set current page to last page
	}

	if ($cmtx_current_page < 1) { //if current page is less than first page
	   $cmtx_current_page = 1; //set current page to first page
	}

	$cmtx_offset = ($cmtx_current_page - 1) * cmtx_setting('comments_per_page'); //the offset of the list, based on current page



	/* *** Sort By *** */
	if (cmtx_setting('show_sort_by')) {

	echo '<div class="cmtx_sort_block">';
	
	echo '<span class="cmtx_sort_text">' . CMTX_SORT_TEXT . '</span>';

	echo '<select class="cmtx_sort_field" title="' . CMTX_SORT_TITLE . '" onchange="window.location.href = this.options[selectedIndex].value;">';

	if (cmtx_setting('show_sort_by_1') && cmtx_setting('show_date')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '1') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '1') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=1' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_1 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=1' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_1 . '</option>';
		}
	}
	if (cmtx_setting('show_sort_by_2') && cmtx_setting('show_date')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '2') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '2') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=2' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_2 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=2' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_2 . '</option>';
		}
	}
	if (cmtx_setting('show_sort_by_3') && cmtx_setting('show_like')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '3') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '3') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=3' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_3 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=3' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_3 . '</option>';
		}
	}
	if (cmtx_setting('show_sort_by_4') && cmtx_setting('show_dislike')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '4') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '4') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=4' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_4 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=4' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_4 . '</option>';
		}
	}
	if (cmtx_setting('show_sort_by_5') && cmtx_setting('show_rating')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '5') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '5') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=5' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_5 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=5' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_5 . '</option>';
		}
	}
	if (cmtx_setting('show_sort_by_6') && cmtx_setting('show_rating')) {
		if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == '6') || (!isset($_GET['cmtx_sort']) && cmtx_setting('comments_order') == '6') ) {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=6' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '" selected="selected">'. CMTX_SORT_6 . '</option>';
		} else {
			echo '<option value="' . cmtx_url_encode(strtok(cmtx_current_page(), '?') . '?cmtx_sort=6' . cmtx_get_query('sort') . CMTX_ANCHOR_COMMENTS) . '">'. CMTX_SORT_6 . '</option>';
		}
	}

	echo '</select>';

	echo '</div>';
	}



	if (cmtx_setting('show_topic') || cmtx_setting('show_sort_by')) {
	echo '<div style="clear: both;"></div>';
	echo '<div class="cmtx_height_below_sort_and_topic"></div>';
	}



	/* *** Average Rating *** */
	echo '<div class="cmtx_average_rating_block">';
	if (cmtx_setting('show_average_rating')) {
	
		echo '<div class="cmtx_average_rating_stars"></div>';

		$cmtx_average_rating = cmtx_average_rating();

		echo '<span class="cmtx_average_rating_text">';
		if (isset($cmtx_rich_snippets)) {
		
			if (cmtx_setting('rich_snippets_markup') == 'Microdata') {
				echo '<span itemprop="rating" itemscope="itemscope" itemtype="http://data-vocabulary.org/Rating">';
				echo '<span itemprop="average">' . $cmtx_average_rating . '</span>';
				echo '/';
				echo '<span itemprop="best">5</span>';
				echo '</span>';
				echo ' (<span itemprop="votes">' . cmtx_number_of_ratings() . '</span>)';
				echo '</span>';
			} else if (cmtx_setting('rich_snippets_markup') == 'Microformats') {
				echo '<span class="rating">';
				echo '<span class="average">' . $cmtx_average_rating . '</span>';
				echo '/';
				echo '<span class="best">5</span>';
				echo '</span>';
				echo ' (<span class="votes">' . cmtx_number_of_ratings() . '</span>)';
				echo '</span>';
			} else if (cmtx_setting('rich_snippets_markup') == 'RDFa') {
				echo '<span rel="v:rating">';
				echo '<span typeof="v:Rating">';
				echo '<span property="v:average">' . $cmtx_average_rating . '</span>';
				echo '/';
				echo '<span property="v:best">5</span>';
				echo '</span>';
				echo '</span>';
				echo ' (<span property="v:votes">' . cmtx_number_of_ratings() . '</span>)';
				echo '</span>';
			}
		
		} else {
			echo $cmtx_average_rating . '/5 (' . cmtx_number_of_ratings() . ')</span>';
		}
			
	}
	echo '</div>';


	
	/* *** Pagination (Top) *** */
	echo '<div class="cmtx_pagination_block_top">';
	if (cmtx_setting('enabled_pagination') && cmtx_setting('show_pagination_top') && $cmtx_total_pages > 1) {
		cmtx_paginate($cmtx_current_page, cmtx_setting('range_of_pages'), $cmtx_total_pages);
	}
	echo '</div>';



	/* *** Social *** */
	echo '<div class="cmtx_social_block">';
	if (cmtx_setting('show_social')) {
	
	$cmtx_social_url = cmtx_url_encode_spaces(cmtx_get_page_url());
	$cmtx_social_title = cmtx_url_encode_spaces(cmtx_get_page_reference());
	
	$cmtx_social_url = str_ireplace('&amp;', '%26', $cmtx_social_url); //convert &amp; to %26
	$cmtx_social_title = str_ireplace('&amp;', '%26', $cmtx_social_title); //convert &amp; to %26

	$cmtx_social_attribute = ''; //initialize variable

	if (cmtx_setting('social_new_window')) {
		$cmtx_social_attribute = ' target="_blank"';
	}

	echo '<div class="cmtx_social_images">';

	if (cmtx_setting('show_social_facebook')) {
		echo '<a href="http://www.facebook.com/sharer.php?u=' . $cmtx_social_url . '&amp;t=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/facebook.png" class="cmtx_social_image" title="Facebook" alt="Facebook"/></a>';
	}
	if (cmtx_setting('show_social_delicious')) {
		echo '<a href="http://delicious.com/post?url=' . $cmtx_social_url . '&amp;title=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/delicious.png" class="cmtx_social_image" title="del.icio.us" alt="del.icio.us"/></a>';
	}
	if (cmtx_setting('show_social_stumbleupon')) {
		echo '<a href="http://www.stumbleupon.com/submit?url=' . $cmtx_social_url . '&amp;title=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/stumbleupon.png" class="cmtx_social_image" title="StumbleUpon" alt="StumbleUpon"/></a>';
	}
	if (cmtx_setting('show_social_digg')) {
		echo '<a href="http://digg.com/submit?phase=2&amp;url=' . $cmtx_social_url . '&amp;title=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/digg.png" class="cmtx_social_image" title="Digg" alt="Digg"/></a>';
	}
	if (cmtx_setting('show_social_technorati')) {
		echo '<a href="http://technorati.com/faves?add=' . $cmtx_social_url . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/technorati.png" class="cmtx_social_image" title="Technorati" alt="Technorati"/></a>';
	}
	if (cmtx_setting('show_social_google')) {
		echo '<a href="https://plus.google.com/share?url=' . $cmtx_social_url . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/google.png" class="cmtx_social_image" title="Google+" alt="Google+"/></a>';
	}
	if (cmtx_setting('show_social_reddit')) {
		echo '<a href="http://reddit.com/submit?url=' . $cmtx_social_url . '&amp;title=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/reddit.png" class="cmtx_social_image" title="Reddit" alt="Reddit"/></a>';
	}
	if (cmtx_setting('show_social_myspace')) {
		echo '<a href="http://www.myspace.com/Modules/PostTo/Pages/?u=' . $cmtx_social_url . '&amp;t=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/myspace.png" class="cmtx_social_image" title="MySpace" alt="MySpace"/></a>';
	}
	if (cmtx_setting('show_social_twitter')) {
		echo '<a href="http://twitter.com/home?status=' . $cmtx_social_title . '%20-%20' . $cmtx_social_url . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/twitter.png" class="cmtx_social_image" title="Twitter" alt="Twitter"/></a>';
	}
	if (cmtx_setting('show_social_linkedin')) {
		echo '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $cmtx_social_url . '&amp;title=' . $cmtx_social_title . '" rel="nofollow"' . $cmtx_social_attribute . '><img src="' . cmtx_commentics_url() . 'images/social/linkedin.png" class="cmtx_social_image" title="LinkedIn" alt="LinkedIn"/></a>';
	}

	echo '</div>';
	}
	echo '</div>';



	echo '<div style="clear: both;"></div>';



	/* *** Comments *** */
	echo '<div class="cmtx_height_above_comment_boxes"></div>';

	$cmtx_sort = cmtx_get_sort_by();

	$cmtx_comments_query = cmtx_db_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '0' AND `is_approved` = '1' AND `page_id` = '$cmtx_page_id' ORDER BY $cmtx_sort;"); //get comments from database

	$cmtx_loop_counter = 0;
	$cmtx_comment_counter = 0;
	$cmtx_exit_loop = false;
	
	while ($cmtx_comments = cmtx_db_fetch_assoc($cmtx_comments_query)) { //while there are comments

		cmtx_get_comment_and_replies($cmtx_comments['id']);

		if ($cmtx_exit_loop) {
			break;
		}

	}

	echo '<div class="cmtx_height_below_comment_boxes"></div>';



	/* *** RSS *** */
	echo '<div class="cmtx_rss_block">';
	if (cmtx_setting('show_rss')) { ?>
	<a href="<?php echo cmtx_commentics_url() . 'rss.php?id=' . $cmtx_page_id;?>" rel="nofollow"><img src="<?php echo cmtx_commentics_url() . 'images/misc/rss.png';?>" class="cmtx_rss_image" title="<?php echo CMTX_TITLE_RSS; ?>" alt="RSS"/></a>
	<a href="<?php echo cmtx_commentics_url() . 'rss.php?id=' . $cmtx_page_id;?>" class="cmtx_rss_link" title="<?php echo CMTX_TITLE_RSS; ?>" rel="nofollow"><?php echo CMTX_RSS ?></a>
	<?php }
	echo '</div>';



	/* *** Pagination (Bottom) *** */
	echo '<div class="cmtx_pagination_block_bottom">';
	if (cmtx_setting('enabled_pagination') && cmtx_setting('show_pagination_bottom') && $cmtx_total_pages > 1) {
		cmtx_paginate($cmtx_current_page, cmtx_setting('range_of_pages'), $cmtx_total_pages);
	}
	echo '</div>';



	/* *** Page Number *** */
	echo '<div class="cmtx_page_number_block">';
	if (cmtx_setting('show_page_number')) { //if enabled
		echo '<span class="cmtx_page_number_text">';
		if (cmtx_setting('enabled_pagination')) { //if pagination enabled
			printf(CMTX_INFO_PAGE, $cmtx_current_page, $cmtx_total_pages); //display page number
		}
		echo '</span>';
	}
	echo '</div>';



	if (isset($cmtx_rich_snippets)) {
		echo '</div>';
	}

}

echo '<div style="clear: left;"></div>';