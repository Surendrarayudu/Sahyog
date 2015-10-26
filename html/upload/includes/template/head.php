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

<!-- Start of Commentics -->

<div class="cmtx_container">

<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>

<?php if (cmtx_setting('enabled_privacy') || cmtx_setting('enabled_terms')) { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo cmtx_commentics_url(); ?>external/colorbox/colorbox.css"/>
<?php } ?>

<link rel="stylesheet" type="text/css" href="<?php echo cmtx_commentics_url(); ?>css/<?php echo cmtx_setting('theme'); ?>.css"/>

<?php if (file_exists($cmtx_path . 'css/custom/' . cmtx_setting('theme') . '.css')) { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo cmtx_commentics_url(); ?>css/custom/<?php echo cmtx_setting('theme'); ?>.css"/>
<?php } ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo cmtx_commentics_url(); ?>javascript/jquery.cookie.js"></script>

<?php if (cmtx_setting('enabled_privacy') || cmtx_setting('enabled_terms')) { ?>
	<script type="text/javascript" src="<?php echo cmtx_commentics_url(); ?>external/colorbox/jquery.colorbox-min.js"></script>
<?php } ?>

<?php if (cmtx_setting('show_average_rating')) { ?>
	<script type="text/javascript" src="<?php echo cmtx_commentics_url(); ?>external/raty/jquery.raty.min.js"></script>
<?php } ?>