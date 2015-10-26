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
cmtx_define('CMTX_COMMENTS_HEADING', 'Коментари');

/* No comments message */
cmtx_define('CMTX_NO_COMMENTS', 'Все още няма коментари.');

/* Sort By */
cmtx_define('CMTX_SORT_TEXT', 'Sort');
cmtx_define('CMTX_SORT_TITLE', 'Подреди по');
cmtx_define('CMTX_SORT_1', 'Най-нови');
cmtx_define('CMTX_SORT_2', 'Най-стари');
cmtx_define('CMTX_SORT_3', 'Полезност');
cmtx_define('CMTX_SORT_4', 'Безполезност');
cmtx_define('CMTX_SORT_5', 'Позитивни');
cmtx_define('CMTX_SORT_6', 'Критични');

/* Topic */
cmtx_define('CMTX_TOPIC_INTRO', 'Тема');

/* Average Rating */
cmtx_define('CMTX_RATE_NO_PAGE', 'This page no longer exists');
cmtx_define('CMTX_RATE_ALREADY_RATED', 'You\'ve already rated');
cmtx_define('CMTX_RATE_BANNED', 'You\'ve been banned');

/* Says */
cmtx_define('CMTX_SAYS', 'казва...');

/* Read More */
cmtx_define('CMTX_READ_MORE', '... Прочети повече');
cmtx_define('CMTX_TITLE_READ_MORE', 'Прочети целия коментар');

/* Admin */
cmtx_define('CMTX_REPLY_INTRO', 'Администратор:');

/* Date */
cmtx_define('CMTX_TODAY', 'Днес');
cmtx_define('CMTX_YESTERDAY', 'Вчера');

/* Like Dislike */
cmtx_define('CMTX_TITLE_LIKE', 'Гласувай позитивно за този коментар');
cmtx_define('CMTX_TITLE_DISLIKE', 'Гласувай негативно за този коментар');
cmtx_define('CMTX_VOTE_NO_COMMENT', 'Този коментар вече не съществува');
cmtx_define('CMTX_VOTE_OWN_COMMENT', 'Не можете да гласувате за собствения си коментар');
cmtx_define('CMTX_VOTE_ALREADY_VOTED', 'Вие вече сте гласували за този коментар');
cmtx_define('CMTX_VOTE_BANNED', 'Вие сте били вече баннати!');

/* Flag */
cmtx_define('CMTX_FLAG', 'Флаг');
cmtx_define('CMTX_TITLE_FLAG', 'Докладвай коментара');
cmtx_define('CMTX_FLAG_DIALOG_HEADING', 'Report Comment');
cmtx_define('CMTX_FLAG_DIALOG_CONTENT', 'Сигурни ли сте, че искате да докладвате този коментар?');
cmtx_define('CMTX_FLAG_DIALOG_YES', 'Yes');
cmtx_define('CMTX_FLAG_DIALOG_NO', 'No');
cmtx_define('CMTX_FLAG_NO_COMMENT', 'Този коментар вече не съществува');
cmtx_define('CMTX_FLAG_OWN_COMMENT', 'Не можете да докладвате собствения си коментар');
cmtx_define('CMTX_FLAG_ADMIN_COMMENT', 'Не можете да докладвате коментар на админа');
cmtx_define('CMTX_FLAG_BANNED', 'Вече сте били баннати!');
cmtx_define('CMTX_FLAG_REPORT_LIMIT', 'Не можете да докладвате повече коментари');
cmtx_define('CMTX_FLAG_ALREADY_REPORTED', 'Вече сте докладвали този коментар');
cmtx_define('CMTX_FLAG_ALREADY_FLAGGED', 'Този коментар вече е бил докладван');
cmtx_define('CMTX_FLAG_ALREADY_VERIFIED', 'Този коментар вече е бил проверен');
cmtx_define('CMTX_FLAG_REPORT_SENT', 'Благодарим Ви за доклада');

/* Permalink */
cmtx_define('CMTX_PERMALINK', 'Permalink');
cmtx_define('CMTX_TITLE_PERMALINK', 'Permalink за този коментар');

/* Reply */
cmtx_define('CMTX_REPLY', 'Отговори');
cmtx_define('CMTX_TITLE_REPLY', 'Отговори на този коментар');

/* RSS */
cmtx_define('CMTX_RSS', 'RSS Alerts');
cmtx_define('CMTX_TITLE_RSS', 'Get RSS alerts for this page');

/* Page Number */
cmtx_define('CMTX_INFO_PAGE', 'Страница %d от %d');

/* Pagination */
cmtx_define('CMTX_PAGINATION_FIRST', 'Първа');
cmtx_define('CMTX_PAGINATION_PREVIOUS', '<');
cmtx_define('CMTX_PAGINATION_NEXT', '>');
cmtx_define('CMTX_PAGINATION_LAST', 'Последна');
cmtx_define('CMTX_TITLE_PAG_FIRST', 'Първа');
cmtx_define('CMTX_TITLE_PAG_PREVIOUS', 'Последна');
cmtx_define('CMTX_TITLE_PAG_NEXT', 'Следваща');
cmtx_define('CMTX_TITLE_PAG_LAST', 'Последна');

?>