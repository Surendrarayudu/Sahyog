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
cmtx_define('CMTX_COMMENTS_HEADING', 'ความคิดเห็น');

/* No comments message */
cmtx_define('CMTX_NO_COMMENTS', 'ยังไม่มีข้อความคิดเห็น');

/* Sort By */
cmtx_define('CMTX_SORT_TEXT', 'Sort');
cmtx_define('CMTX_SORT_TITLE', 'เรียงตาม');
cmtx_define('CMTX_SORT_1', 'ใหม่ล่าสุด');
cmtx_define('CMTX_SORT_2', 'เก่าแก่ที่สุด');
cmtx_define('CMTX_SORT_3', 'เป็นประโยชน์');
cmtx_define('CMTX_SORT_4', 'ไร้ประโยชน์');
cmtx_define('CMTX_SORT_5', 'บวก');
cmtx_define('CMTX_SORT_6', 'วิกฤต');

/* Topic */
cmtx_define('CMTX_TOPIC_INTRO', 'คุณทาน');

/* Average Rating */
cmtx_define('CMTX_RATE_NO_PAGE', 'This page no longer exists');
cmtx_define('CMTX_RATE_ALREADY_RATED', 'You\'ve already rated');
cmtx_define('CMTX_RATE_BANNED', 'You\'ve been banned');

/* Says */
cmtx_define('CMTX_SAYS', 'แสดงความคิดเห็น...');

/* Read More */
cmtx_define('CMTX_READ_MORE', '... อ่านเพิ่มเติม');
cmtx_define('CMTX_TITLE_READ_MORE', 'อ่านความคิดเห็นเต็ม');

/* Admin Reply */
cmtx_define('CMTX_REPLY_INTRO', 'ผู้ควบคุมดูแล:');

/* Date */
cmtx_define('CMTX_TODAY', 'วันนี้');
cmtx_define('CMTX_YESTERDAY', 'เมื่อวาน');

/* Like Dislike */
cmtx_define('CMTX_TITLE_LIKE', 'โหวต: เห็นด้วย');
cmtx_define('CMTX_TITLE_DISLIKE', 'โหวต: ไม่เห็นด้วย');
cmtx_define('CMTX_VOTE_NO_COMMENT', 'ไม่พบข้อความคิดเห็นนี้');
cmtx_define('CMTX_VOTE_OWN_COMMENT', 'คุณไม่สามารถลงคะแนนสำหรับความเห็นของคุณเอง');
cmtx_define('CMTX_VOTE_ALREADY_VOTED', 'คุณได้โหวตสำหรับข้อความคิดเห็นนี้ไปแล้ว');
cmtx_define('CMTX_VOTE_BANNED', 'คุณได้รับก่อนหน้านี้ห้าม');

/* Flag */
cmtx_define('CMTX_FLAG', 'รายงาน');
cmtx_define('CMTX_TITLE_FLAG', 'รายงานข้อความคิดเห็นนี้t');
cmtx_define('CMTX_FLAG_DIALOG_HEADING', 'Report Comment');
cmtx_define('CMTX_FLAG_DIALOG_CONTENT', 'คุณแน่ใจว่าคุณต้องการรายงานเกี่ยวกับข้อความคิดเห็นนี้?');
cmtx_define('CMTX_FLAG_DIALOG_YES', 'Yes');
cmtx_define('CMTX_FLAG_DIALOG_NO', 'No');
cmtx_define('CMTX_FLAG_NO_COMMENT', 'ไม่พบข้อความคิดเห็นนี้');
cmtx_define('CMTX_FLAG_OWN_COMMENT', 'คุณไม่สามารถรายงานความเห็นของคุณเอง');
cmtx_define('CMTX_FLAG_ADMIN_COMMENT', 'You cannot report an admin comment');
cmtx_define('CMTX_FLAG_BANNED', 'คุณได้รับก่อนหน้านี้ห้าม');
cmtx_define('CMTX_FLAG_REPORT_LIMIT', 'คุณไม่สามารถรายงานเกี่ยวกับข้อความคิดเห็นได้อีก');
cmtx_define('CMTX_FLAG_ALREADY_REPORTED', 'คุณได้รายงานเกี่ยวกับข้อความคิดเห็นนี้แล้ว');
cmtx_define('CMTX_FLAG_ALREADY_FLAGGED', 'ข้อความคิดเห็นนี้ถูกรายงานแล้ว');
cmtx_define('CMTX_FLAG_ALREADY_VERIFIED', 'ข้อความคิดเห็นนี้ได้รับการตรวจสอบแล้ว');
cmtx_define('CMTX_FLAG_REPORT_SENT', 'ขอบคุณสำหรับการรายงาน');

/* Permalink */
cmtx_define('CMTX_PERMALINK', 'Permalink');
cmtx_define('CMTX_TITLE_PERMALINK', 'Permalink for this comment');

/* Reply */
cmtx_define('CMTX_REPLY', 'ตอบ');
cmtx_define('CMTX_TITLE_REPLY', 'ตอบข้อความคิดเห็นนี้');

/* RSS */
cmtx_define('CMTX_RSS', 'RSS Alerts');
cmtx_define('CMTX_TITLE_RSS', 'Get RSS alerts for this page');

/* Page Number */
cmtx_define('CMTX_INFO_PAGE', 'หน้า %d จาก %d');

/* Pagination */
cmtx_define('CMTX_PAGINATION_FIRST', 'หน้าแรก');
cmtx_define('CMTX_PAGINATION_PREVIOUS', '<');
cmtx_define('CMTX_PAGINATION_NEXT', '>');
cmtx_define('CMTX_PAGINATION_LAST', 'หน้าสุดท้าย');
cmtx_define('CMTX_TITLE_PAG_FIRST', 'หน้าแรก');
cmtx_define('CMTX_TITLE_PAG_PREVIOUS', 'หน้าก่อนหน้า');
cmtx_define('CMTX_TITLE_PAG_NEXT', 'หน้าถัดไป');
cmtx_define('CMTX_TITLE_PAG_LAST', 'หน้าสุดท้าย');

?>