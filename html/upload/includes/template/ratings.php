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

$cmtx_ratings = '<select name="cmtx_rating" class="cmtx_field cmtx_select_field cmtx_rating_field" title="' . CMTX_TITLE_RATING . '">
<option value="">' . CMTX_TOP_RATING . '</option>
<option value="1">1 - ' . CMTX_RATING_ONE . '</option>
<option value="2">2 - ' . CMTX_RATING_TWO . '</option>
<option value="3">3 - ' . CMTX_RATING_THREE . '</option>
<option value="4">4 - ' . CMTX_RATING_FOUR . '</option>
<option value="5">5 - ' . CMTX_RATING_FIVE . '</option>
</select>';

$cmtx_rated = '<select name="cmtx_rating" disabled="disabled" class="cmtx_field cmtx_select_field cmtx_rating_field" title="' . CMTX_HAS_RATED . '">
<option value="">' . CMTX_HAS_RATED . '</option>
</select>';

?>