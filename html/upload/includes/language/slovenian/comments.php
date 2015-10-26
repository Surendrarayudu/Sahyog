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

/* Anchors */
cmtx_define('CMTX_ANCHOR_COMMENTS', '#cmtx_comments');

/* Heading */
cmtx_define('CMTX_COMMENTS_HEADING', 'Komentarji');

/* No comments message */
cmtx_define('CMTX_NO_COMMENTS', 'Ni še nobenega komentarja.');

/* Sort By */
cmtx_define('CMTX_SORT_TEXT', 'Sort');
cmtx_define('CMTX_SORT_TITLE', 'Razvrsti komentarje');
cmtx_define('CMTX_SORT_1', 'Najnovejši');
cmtx_define('CMTX_SORT_2', 'Najstarejši');
cmtx_define('CMTX_SORT_3', 'Koristni');
cmtx_define('CMTX_SORT_4', 'Neuporabni');
cmtx_define('CMTX_SORT_5', 'Pozitivni');
cmtx_define('CMTX_SORT_6', 'Kritični');

/* Topic */
cmtx_define('CMTX_TOPIC_INTRO', 'Pregledujete');

/* Average Rating */
cmtx_define('CMTX_RATE_NO_PAGE', 'This page no longer exists');
cmtx_define('CMTX_RATE_ALREADY_RATED', 'You\'ve already rated');
cmtx_define('CMTX_RATE_BANNED', 'You\'ve been banned');

/* Says */
cmtx_define('CMTX_SAYS', 'pravi...');

/* Read More */
cmtx_define('CMTX_READ_MORE', '... Preberite več');
cmtx_define('CMTX_TITLE_READ_MORE', 'Preberite celoten komentar');

/* Admin Reply */
cmtx_define('CMTX_REPLY_INTRO', 'Administrator:');

/* Date */
cmtx_define('CMTX_TODAY', 'Danes');
cmtx_define('CMTX_YESTERDAY', 'Včeraj');

/* Like Dislike */
cmtx_define('CMTX_TITLE_LIKE', 'Glasujte za ta komentar');
cmtx_define('CMTX_TITLE_DISLIKE', 'Glasujte proti temu komentarju');
cmtx_define('CMTX_VOTE_NO_COMMENT', 'Ta komentar ne obstaja več');
cmtx_define('CMTX_VOTE_OWN_COMMENT', 'Ne moreš glasovati za svoj komentar');
cmtx_define('CMTX_VOTE_ALREADY_VOTED', 'Za ta komentar ste že glasovali');
cmtx_define('CMTX_VOTE_BANNED', 'Ti so bili že prepovedani');

/* Flag */
cmtx_define('CMTX_FLAG', 'Označite');
cmtx_define('CMTX_TITLE_FLAG', 'Prijavite ta komentar');
cmtx_define('CMTX_FLAG_DIALOG_HEADING', 'Report Comment');
cmtx_define('CMTX_FLAG_DIALOG_CONTENT', 'Ali ste prepričani, da želite prijaviti ta komentar?');
cmtx_define('CMTX_FLAG_DIALOG_YES', 'Yes');
cmtx_define('CMTX_FLAG_DIALOG_NO', 'No');
cmtx_define('CMTX_FLAG_NO_COMMENT', 'ta komentar ne obstaja več');
cmtx_define('CMTX_FLAG_OWN_COMMENT', 'Ne morete prijaviti lastnega komentarja');
cmtx_define('CMTX_FLAG_ADMIN_COMMENT', 'Administratorjevega komentarja ne morete prijaviti');
cmtx_define('CMTX_FLAG_BANNED', 'Ti so bili že prepovedani');
cmtx_define('CMTX_FLAG_REPORT_LIMIT', 'Ne morete več prijavljati komentarjev');
cmtx_define('CMTX_FLAG_ALREADY_REPORTED', 'Ta komentar ste že prijavili');
cmtx_define('CMTX_FLAG_ALREADY_FLAGGED', 'Ta komentar je že bil označen');
cmtx_define('CMTX_FLAG_ALREADY_VERIFIED', 'Ta komentar je že bil potrjen');
cmtx_define('CMTX_FLAG_REPORT_SENT', 'Hvala za poročilo');

/* Permalink */
cmtx_define('CMTX_PERMALINK', 'Permalink povezava');
cmtx_define('CMTX_TITLE_PERMALINK', 'Permalink povezava za ta komentar');

/* Reply */
cmtx_define('CMTX_REPLY', 'Odgovor');
cmtx_define('CMTX_TITLE_REPLY', 'Odgovorite na ta komentar');

/* RSS */
cmtx_define('CMTX_RSS', 'RSS Alerts');
cmtx_define('CMTX_TITLE_RSS', 'Get RSS alerts for this page');

/* Page Number */
cmtx_define('CMTX_INFO_PAGE', 'Stran %d od %d');

/* Pagination */
cmtx_define('CMTX_PAGINATION_FIRST', 'prva');
cmtx_define('CMTX_PAGINATION_PREVIOUS', '<');
cmtx_define('CMTX_PAGINATION_NEXT', '>');
cmtx_define('CMTX_PAGINATION_LAST', 'zadnja');
cmtx_define('CMTX_TITLE_PAG_FIRST', 'prvi');
cmtx_define('CMTX_TITLE_PAG_PREVIOUS', 'predhodni');
cmtx_define('CMTX_TITLE_PAG_NEXT', 'naslednji');
cmtx_define('CMTX_TITLE_PAG_LAST', 'zadnji');

?>