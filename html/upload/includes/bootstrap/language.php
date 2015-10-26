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

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/page.php')) { //if custom language file for page exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/page.php'; //load custom language file for page
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/comments.php')) { //if custom language file for comments exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/comments.php'; //load custom language file for comments
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/processor.php')) { //if custom language file for processor exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/processor.php'; //load custom language file for processor
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/form.php')) { //if custom language file for form exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/form.php'; //load custom language file for form
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/countries.php')) { //if custom language file for countries exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/countries.php'; //load custom language file for countries
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/ratings.php')) { //if custom language file for ratings exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/ratings.php'; //load custom language file for ratings
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/rss.php')) { //if custom language file for RSS exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/rss.php'; //load custom language file for RSS
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/subscribers.php')) { //if custom language file for subscribers exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/subscribers.php'; //load custom language file for subscribers
}

if (file_exists($cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/locale.php')) { //if custom language file for locale exists
	require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/custom/locale.php'; //load custom language file for locale
}

require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/page.php'; //load language file for page
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/comments.php'; //load language file for comments
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/processor.php'; //load language file for processor
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/form.php'; //load language file for form
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/countries.php'; //load language file for countries
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/ratings.php'; //load language file for ratings
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/rss.php'; //load language file for RSS
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/subscribers.php'; //load language file for subscribers
require_once $cmtx_path . 'includes/language/' . cmtx_setting('language_frontend') . '/locale.php'; //load language file for locale

?>