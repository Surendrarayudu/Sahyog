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

<?php
if (cmtx_setting('sort_order_parts') == '1,2') { //display comments first

	if (cmtx_setting('split_screen')) { //side-by-side layout
		
		if (cmtx_setting('center_screen')) { //center layout
			echo '<div class="cmtx_split_center">';
		}
	
		echo '<table class="cmtx_split_cf_table">';
		echo '<tr>';
		echo '<td class="cmtx_split_cf_td_comments">';
		require_once $cmtx_path . 'includes/template/comments.php'; //load comments
		echo '</td>';
		echo '<td class="cmtx_split_cf_td_middle"></td>';
		echo '<td class="cmtx_split_cf_td_form">';
		require_once $cmtx_path . 'includes/template/form.php'; //load form
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		
		if (cmtx_setting('center_screen')) { //center layout
			echo '</div>';
		}
		
	} else { //vertical layout
	
		if (cmtx_setting('center_screen')) { echo '<div class="cmtx_center">'; } //center layout
		require_once $cmtx_path . 'includes/template/comments.php'; //load comments
		echo '<div class="cmtx_divider"></div>'; //height between comments/form
		require_once $cmtx_path . 'includes/template/form.php'; //load form
		if (cmtx_setting('center_screen')) { echo '</div>'; } //center layout
		
	}
	
} else { //display form first

	if (cmtx_setting('split_screen')) { //side-by-side layout
	
		if (cmtx_setting('center_screen')) { //center layout
			echo '<div class="cmtx_split_center">';
		}
	
		echo '<table class="cmtx_split_fc_table">';
		echo '<tr>';
		echo '<td class="cmtx_split_fc_td_form">';
		require_once $cmtx_path . 'includes/template/form.php'; //load form
		echo '</td>';
		echo '<td class="cmtx_split_fc_td_middle"></td>';
		echo '<td class="cmtx_split_fc_td_comments">';
		require_once $cmtx_path . 'includes/template/comments.php'; //load comments
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		
		if (cmtx_setting('center_screen')) { //center layout
			echo '</div>';
		}
		
	} else { //vertical layout
	
		if (cmtx_setting('center_screen')) { echo '<div class="cmtx_center">'; } //center layout
		require_once $cmtx_path . 'includes/template/form.php'; //load form
		echo '<div class="cmtx_divider"></div>'; //height between form/comments
		require_once $cmtx_path . 'includes/template/comments.php'; //load comments
		if (cmtx_setting('center_screen')) { echo '</div>'; } //center layout
		
	}
	
}
?>

</div>

<!-- End of Commentics -->