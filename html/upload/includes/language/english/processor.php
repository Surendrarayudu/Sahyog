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
cmtx_define('CMTX_ERROR_NUMBER', 'Sorry but %d error was found when processing your comment.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Sorry but %d errors were found when processing your comment.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Please correct this error and submit the form again:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Please correct these errors and submit the form again:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Preview Only');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Thank you.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Your comment is awaiting approval.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Thank you.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Your comment has been added.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'The name field can not be empty. Please enter your name.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Only one name can be entered for the name field. Please enter one name.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'The name entered is reserved. Please choose another name.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'The name entered is forbidden. Please choose another name.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'The name entered is not yours. Please enter your real name.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'The name entered contains a link. Please enter your real name.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'The email field can not be empty. Please enter your email.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'The email address entered is incorrect. Please check your entry.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'The email address entered is reserved. Please enter your email.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'The email address entered is forbidden. Please enter another email.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'The email address entered is not yours. Please enter your email.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'The website field can not be empty. Please enter your website.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'The website address entered is incorrect. Please check your entry.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'The website address entered is reserved. Please enter your website.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'The website address entered is forbidden. Please remove it.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'The website address in your comment is forbidden. Please remove it.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'The website address entered is not yours. Please enter your website.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'The town field can not be empty. Please enter your town.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'The town entered is reserved. Please enter another town.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'The town entered is forbidden. Please enter another town.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'The town entered is not yours. Please enter your town.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'The town entered contains a link. Please enter your town.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'The country field was not selected. Please select your country.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'The selected country is invalid. Please contact the administrator.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'The rating field was not selected. Please select your rating.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'The selected rating is invalid. Please contact the administrator.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'The comment you are replying to is invalid. Please try again.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'The comment field can not be empty. Please enter a comment.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'The comment entered was too short. Please enter a longer comment.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'The comment entered was too long. Please enter a shorter comment.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'The comment entered contains too many lines. Please enter fewer lines.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'You have submitted this comment. Please submit a new comment.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'The comment entered contains too many smilies (Max: %d).');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'The comment entered contains offensive words. Please remove these words.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Swearing is not allowed. Please remove the swear words from your comment.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Spamming is not allowed. Please remove the spam from your comment.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'The comment contains a long word. Please remove this word.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'The comment entered contains too many capitals. Please enter fewer capitals.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'The comment entered contains a link. Please remove the link.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'The comment entered contains repeating characters. Please remove them.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'The question field can not be empty. Please enter the answer.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'The answer to the question was incorrect. Please try again.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'The captcha field can not be empty. Please enter the characters.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'The characters for the captcha were incorrect. Please try again.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Your last comment was submitted recently. Please wait longer.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'You have submitted several comments recently. Please wait a while.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Please enable your web browser to send referrer information.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Please enable your web browser to respect the maximum field lengths.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'You are now banned. This can be due to a variety of reasons including swearing, spamming and hacker-related behaviour. If you feel that this was in error, please contact the website administrator, quoting your IP address.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'You have previously been banned.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'No security key.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Incorrect security key.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'No resubmit key.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Invalid resubmit key.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Injection attempt.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Reserved name entered.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Banned name entered.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Dummy name entered.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link entered in name.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Reserved email address entered.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Banned email address entered.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Dummy email address entered.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Reserved website address entered.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Banned website entered in website.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Dummy website address entered.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Reserved town entered.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Banned town entered.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Dummy town entered.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link entered in town.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Mild swearing.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Strong swearing.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Too many capitals.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link entered in comment.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Repeats entered in comment.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Approve all.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Reserved name entered.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Banned name entered.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Dummy name entered.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link entered in name.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Reserved email address entered.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Banned email address entered.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Dummy email address entered.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website entered.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Reserved website address entered.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Banned website entered in website.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Dummy website address entered.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Reserved town entered.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Banned town entered.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Dummy town entered.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link entered in town.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link entered.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Repeats entered.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Image entered.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video entered.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Mild swearing.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Strong swearing.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Too many capitals.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>