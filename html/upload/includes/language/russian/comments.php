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
cmtx_define('CMTX_COMMENTS_HEADING', 'Отзывы');

/* No comments message */
cmtx_define('CMTX_NO_COMMENTS', 'Отзывов пока нет.');

/* Sort By */
cmtx_define('CMTX_SORT_TEXT', 'Sort');
cmtx_define('CMTX_SORT_TITLE', 'Сортировать по');
cmtx_define('CMTX_SORT_1', 'Новые');
cmtx_define('CMTX_SORT_2', 'Старые');
cmtx_define('CMTX_SORT_3', 'Полезные');
cmtx_define('CMTX_SORT_4', 'Бесполезные');
cmtx_define('CMTX_SORT_5', 'Положительные');
cmtx_define('CMTX_SORT_6', 'Отрицательные');

/* Topic */
cmtx_define('CMTX_TOPIC_INTRO', 'Вы просматриваете');

/* Average Rating */
cmtx_define('CMTX_RATE_NO_PAGE', 'This page no longer exists');
cmtx_define('CMTX_RATE_ALREADY_RATED', 'You\'ve already rated');
cmtx_define('CMTX_RATE_BANNED', 'You\'ve been banned');

/* Says */
cmtx_define('CMTX_SAYS', 'говорит...');

/* Read More */
cmtx_define('CMTX_READ_MORE', '... Читать дальше');
cmtx_define('CMTX_TITLE_READ_MORE', 'Читать отзыв полностью');

/* Admin Reply */
cmtx_define('CMTX_REPLY_INTRO', 'Администратор:');

/* Date */
cmtx_define('CMTX_TODAY', 'Сегодня');
cmtx_define('CMTX_YESTERDAY', 'Вчера');

/* Like Dislike */
cmtx_define('CMTX_TITLE_LIKE', 'Проголосовать за отзыв');
cmtx_define('CMTX_TITLE_DISLIKE', 'Проголосовать против отзыва');
cmtx_define('CMTX_VOTE_NO_COMMENT', 'Данный комментарий больше не существует');
cmtx_define('CMTX_VOTE_OWN_COMMENT', 'Вы не можете голосовать за собственный отзыв');
cmtx_define('CMTX_VOTE_ALREADY_VOTED', 'Вы уже голосовали за данный отзыв');
cmtx_define('CMTX_VOTE_BANNED', 'Вы были забанены');

/* Flag */
cmtx_define('CMTX_FLAG', 'Метка');
cmtx_define('CMTX_TITLE_FLAG', 'Пожаловаться на отзыв');
cmtx_define('CMTX_FLAG_DIALOG_HEADING', 'Report Comment');
cmtx_define('CMTX_FLAG_DIALOG_CONTENT', 'Вы уверены, что хотите пожаловаться на данный отзыв?');
cmtx_define('CMTX_FLAG_DIALOG_YES', 'Yes');
cmtx_define('CMTX_FLAG_DIALOG_NO', 'No');
cmtx_define('CMTX_FLAG_NO_COMMENT', 'Данный комментарий больше не существует');
cmtx_define('CMTX_FLAG_OWN_COMMENT', 'Вы не можете пожаловаться на собственный отзыв');
cmtx_define('CMTX_FLAG_ADMIN_COMMENT', 'You cannot report an admin comment');
cmtx_define('CMTX_FLAG_BANNED', 'Вы были забанены');
cmtx_define('CMTX_FLAG_REPORT_LIMIT', 'Вы больше не можете жаловаться на отзывы');
cmtx_define('CMTX_FLAG_ALREADY_REPORTED', 'Вы уже жаловались на данный отзыв');
cmtx_define('CMTX_FLAG_ALREADY_FLAGGED', 'Данный отзыв уже помечен');
cmtx_define('CMTX_FLAG_ALREADY_VERIFIED', 'Данный отзыв был проверен');
cmtx_define('CMTX_FLAG_REPORT_SENT', 'Спасибо за сообщение');

/* Permalink */
cmtx_define('CMTX_PERMALINK', 'Permalink');
cmtx_define('CMTX_TITLE_PERMALINK', 'Permalink for this comment');

/* Reply */
cmtx_define('CMTX_REPLY', 'Ответить');
cmtx_define('CMTX_TITLE_REPLY', 'Ответить на комментарий');

/* RSS */
cmtx_define('CMTX_RSS', 'RSS Alerts');
cmtx_define('CMTX_TITLE_RSS', 'Get RSS alerts for this page');

/* Page Number */
cmtx_define('CMTX_INFO_PAGE', 'Страница %d из %d');

/* Pagination */
cmtx_define('CMTX_PAGINATION_FIRST', 'В начало');
cmtx_define('CMTX_PAGINATION_PREVIOUS', '<');
cmtx_define('CMTX_PAGINATION_NEXT', '>');
cmtx_define('CMTX_PAGINATION_LAST', 'В конец');
cmtx_define('CMTX_TITLE_PAG_FIRST', 'первое');
cmtx_define('CMTX_TITLE_PAG_PREVIOUS', 'предыдущее');
cmtx_define('CMTX_TITLE_PAG_NEXT', 'следующее');
cmtx_define('CMTX_TITLE_PAG_LAST', 'последнее');

?>