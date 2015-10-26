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

/* Error box */
cmtx_define('CMTX_ERROR_NUMBER', 'ข้อผิดพลาดขออภัยที่ %d พบว่าเมื่อมีการประมวลความคิดเห็นของคุณ');
cmtx_define('CMTX_ERRORS_NUMBER', 'ข้อผิดพลาดขออภัยที่ %d พบว่าเมื่อมีการประมวลความคิดเห็นของคุณ');
cmtx_define('CMTX_ERROR_CORRECTION', 'กรุณาแก้ไขความผิดพลาดที่เกิดขึ้นให้ถูกต้อง และส่งข้อความคิดเห็นของคุณอีกครั้ง:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'กรุณาแก้ไขความผิดพลาดที่เกิดขึ้นให้ถูกต้อง และส่งข้อความคิดเห็นของคุณอีกครั้ง:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'ดูตัวอย่างการแสดงผลเท่านั้น');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'ขอบคุณ');
cmtx_define('CMTX_APPROVAL_TEXT', 'ข้อความคิดเห็นของคุณอยู่ในระหว่างรอการตรวจสอบ');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'ขอบคุณ');
cmtx_define('CMTX_SUCCESS_TEXT', 'ข้อความคิดเห็นของคุณถูกเพิ่มแล้ว');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'ช่องระบุชื่อไม่สามารถเว้นว่าง กรุณาพิมพ์ชื่อของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'ช่องระบุชื่อ สำหรับระบุชื่อเพียงชื่อเดียว กรุณาพิมพ์ชื่อเพียงชื่อเดียว');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'ชื่อซึ่งระบุตรงกับชื่อที่ถูกสงวนไว้ กรุณาใช้ชื่ออื่น');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'ชื่อซึ่งระบุตรงกับชื่อต้องห้าม กรุณาใช้ชื่ออื่น');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'ชื่อซึ่งระบุไม่ใช่ชื่อของคุณ กรุณาพิมพ์ชื่อจริงของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'ชื่อซึ่งระบุเป็นชื่อเชื่อมโยง กรุณาพิมพ์ชื่อจริงของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'ช่องสำหรับที่อยู่อีเมลไม่สามารถเว้นว่าง กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่ถูกต้อง กรุณาตรวจสอบ');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลซึ่งถูกสงวนไว้ กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลต้องห้าม กรุณาใช้ที่อยู่อีเมลอื่น');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่ใช่ที่อยู่อีเมลของคุณ กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'ช่องสำหรับระบุที่อยู่เว็บไซต์ไม่สามารถเว้นว่าง กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุไม่ถูกต้อง กรุณาตรวจสอบ');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุตรงกับที่อยู่เว็บไซต์ซึ่งถูกสงวนไว้ กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุตรงกับที่อยู่เว็บไซต์ต้องห้าม กรุณาลบออก');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ซึ่งปรากฏอยู่ในข้อความคิดเห็น ตรงกับที่อยู่เว็บไซต์ต้องห้าม กรุณาลบออก');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุไม่ใช่ที่อยู่เว็บไซต์ของคุณ กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'ช่องสำหรับระบุชื่อเมืองที่คุณอาศัยอยู่ไม่สามารถเว้นว่าง กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'ชื่อเมืองตามที่ระบุตรงกับชื่อเมืองซึ่งถูกสงวนไว้ กรุณาพิมพ์ชื่อเมืองอื่น');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'ชื่อเมืองตามที่ระบุตรงกับชื่อเมืองต้องห้าม กรุณาพิมพ์ชื่อเมืองอื่น');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'ชื่อเมืองตามที่ระบุไม่ใช่ชื่อเมืองซึ่งคุณอาศัยอยู่ กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเชื่อมโยง กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'ชื่อประเทศไม่ได้ถูกเลือก กรุณาเลือกชื่อประเทศซึ่งคุณอาศัยอยู่');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'ประเทศที่เลือกไม่ถูกต้อง โปรดลองอีกครั้ง');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'ระดับคะแนนไม่ได้ถูกเลือก กรุณาเลือกระดับคะแนน ซึ่งคุณต้องการใช้ในการให้คะแนนแก่เนื้อหาเรื่องที่คุณได้อ่าน');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'การประเมินโดยเลือกไม่ถูกต้อง โปรดลองอีกครั้ง');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'ข้อความคิดเห็นซึ่งคุณเลือกที่จะแสดงความคิดเห็นเพื่อสนับสนุนหรือหักล้างไม่ถูกต้อง กรุณาลองอีกครั้ง');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'ช่องระบุข้อความคิดเห็นไม่สามารถเว้นว่าง กรุณาพิมพ์ข้อความคิดเห็นของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'ข้อความคิดเห็นสั้นเกินไป กรุณาให้รายละเอียดเพิ่มเติม');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'ข้อความคิดเห็นยาวเกินไป กรุณาแก้ไขเพื่อทำให้สั้นกระชับมากขึ้น');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'ข้อความคิดเห็นประกอบด้วยข้อความหลายบรรทัดและเกินจากที่กำหนด กรุณาตรวจทานและแก้ไข');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'ข้อความคิดเห็นตามที่ระบุตรงกับข้อมูลที่มีอยู่เดิม กรุณาให้รายละเอียดที่แตกต่าง');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'ข้อความคิดเห็นประกอบด้วยภาพสัญลักษณ์แสดงอารมณ์เกินจากที่กำหนด (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'ข้อความคิดเห็นประกอบด้วย คำก้าวร้าว กรุณาลบออก');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'ไม่อนุญาตให้ใช้คำหยาบ กรุณาลบคำหยาบนั้นออก');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'ไม่อนุญาตให้ใช้คำซึ่งเป็นสแปม กรุณาลบออกจากข้อความคิดเห็นของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'ข้อความคิดเห็นประกอบด้วย คำที่มีความยาวเกินจากปกติ กรุณาเลือกใช้คำที่สั้นลงแทน');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'ข้อความคิดเห็นประกอบด้วยจำนวนตัวพิมพ์ใหญ่เกินจากที่กำหนด กรุณาลดจำนวนลง');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'ข้อความคิดเห็นประกอบด้วยข้อความเชื่อมโยง กรุณาลบออก');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'ข้อความคิดเห็นประกอบด้วย คำซึ่งมีอักขระเหมือนกันทั้งหมด กรุณาลบออก');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'ช่องตอบคำถามไม่สามารถเว้นว่าง กรุณาพิมพ์คำตอบที่ถูกต้องตรงกับคำถาม');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'คำตอบไม่ถูกต้อง กรุณาใช้ความพยายามอีกครั้ง');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'ช่องระบุโค้ดไม่สามารถเว้นว่าง กรุณาพิมพ์โค้ดตามที่เห็นจากภาพ');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'อักขระในโค้ดตามที่ระบุไม่ถูกต้อง กรุณาพิมพ์อีกครั้ง');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'ข้อความคิดเห็นล่าสุดของคุณเพิ่งถูกเพิ่มได้ไม่นาน กรุณารอสักครู่');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'คุณเพิ่มข้อความคิดเห็นต่อเนื่องและกระชั้นชิดเกินไป กรุณารอสักครู่');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'กรุณาเปิดใช้งาน เพื่อจะสามารถส่งข้อมูลอ้างอิง จากภายในในเว็บบเราเซอร์ของคุณ');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'กรุณาเปิดใช้งานเว็บเบราเซอร์ของคุณที่จะเคารพความยาวสูงสุดเขต');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'คุณเพิ่งถูกแบน กรณีนี้อาจเกิดขึ้นได้จากหลายสาเหตุ ได้แก่ การใช้คำหยาบ การใช้คำซึ่งตรงกับสแปม การมีพฤติกรรมอันส่อไปในทางแฮกเคอร์ หากคุณคิดว่าสิ่งที่เกิดขึ้นกับคุณนี้ ต้องมีอะไรสักอย่างผิดพลาด กรุณาติดต่อกับผู้ควบคุมดูแลพร้อมด้วยข้อมูลซึ่งเป็น IP Address ของคุณ');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'ขออภัย คุณถูกแบนไปแล้วก่อนหน้านี้');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'ไม่พบรหัสนิรภัย');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'รหัสนิรภัยไม่ถูกต้อง');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'ไม่มีคีย์ส่งอีกครั้ง');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'ที่ไม่ถูกต้องที่สำคัญอีกครั้ง');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'พบความพยายามในการแทรกเพิ่มข้อมูล');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกสงวนไว้');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกแบน');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'ชื่อตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'พบข้อความเชื่อมโยงในช่องระบุชื่อ');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกสงวนไว้');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกแบน');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุเป็นที่อยู่เว็บไซต์ซึ่งถูกสงวนไว้');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุในช่องที่อยู่เว็บไซต์ เป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ในข้อความคิดเห็นเป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'ท่อยู่เว็บไซต์ตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเมืองซึ่งถูกสงวนไว้');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเมืองซึ่งถูกแบน');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'ชื่อเมืองตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'ชื่อเมืองตามที่ระบุเป็นข้อความเชื่อมโยง');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'พบคำหยาบ');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'พบคำหยาบรุนแรง');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'พบการสแปม');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'พบจำนวนตัวพิมพ์ใหญ่มีมากกว่าที่กำหนด');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'พบข้อความเชื่อมโยงในข้อความคิดเห็น');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'การเพิ่มข้อความคิดเห็นเป็นการกระทำซ้ำ');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'ตรวจสอบทั้งหมด');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกสงวนไว้');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกแบน');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'ชื่อตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'ชือ่ในช่องระบุชื่อ เป็นข้อความเชื่อมโยง');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลซึ่งสงวนไว้');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกแบน');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่น่าเชื่อถือ');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'ที่อยู่เว็บไซต์ตามที่ถูกระบุ');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตรงกับที่อยู่เว็บไซต์ซึ่งสงวนไว้');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ในช่องที่อยู่เว็บไซต์เป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ในข้อความคิดเห็นเป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'ที่อยู่เว็บไซต์ไม่น่าเชื่อถือ');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'ชื่อเมืองตรงกับชื่อเมืองซึ่งสงวนไว้');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'ชื่อเมืองตรงกับชื่อเมืองที่ถูกแบน');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'ชื่อเมืองไม่น่าเชื่อถือ');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'ชื่อเมืองเป็นข้อความเชื่อมโยง');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'ข้อความคิดเห็นมีข้อความเชื่อมโยง');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'เพิ่มข้อความคิดเห็นซ้ำ');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'ข้อมูลภาพ');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'วิดีโอที่ป้อน');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'คำหยาบ');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'คำหยาบรุนแรง');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'คำสแปม.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'ตัวพิมพ์ใหญ่มากเกินไป');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>