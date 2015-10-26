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
cmtx_define('CMTX_ERROR_NUMBER', 'Извините, была найдена %d ошибка при обработке Вашего комментария.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Извините, %d  ошибки были найдены при обработке Вашего комментария.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Пожалуйста, исправьте ошибку и отправьте форму снова:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Пожалуйста, исправьте ошибки и отправьте форму снова:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Только просмотр');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Спасибо.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Ваш комментарий ожидает подтверждения.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Спасибо.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Ваш комментарий добавлен.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Поле имя не может быть пустым. Пожалуйста, введите Ваше имя.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'В поле Имя можно ввести только одно имя. Пожалуйста, введите одно имя.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Такое имя уже существует. Пожалуйста, выберите другое имя.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Такое имя недопустимо. Пожалуйста, выберите другое имя');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Это не Ваше имя. Пожалуйста, введите Ваше настоящее имя.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Имя содержит ссылку. Пожалуйста, введите Ваше настоящее имя.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Поле электронная почта не может быть пустым. Пожалуйста, введите Ваш электронный адрес.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Возможна ошибка в написании электронной почты. Пожалуйста, проверьте Ваш электронный адрес.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Данная электронная почта уже используется. Пожалуйста, введите другую электронную почту.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Данная электронная почта недопустима. Пожалуйста, введите другую электронную почту.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Введенная электронная почта принадлежит не Вам. Пожалуйста, введите Ваш электронный адрес.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Поле Сайт не может быть пустым. Пожалуйста, введите адрес Вашего сайта.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Возможно, адрес сайта введен некорректно. Пожалуйста, проверьте Вашу запись.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Данный сайт уже используется. Пожалуйста, введите адрес Вашего сайта.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Введенный сайт запрещен. Пожалуйста, удалите его.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Комментарий содержит запрещенный сайт. Пожалуйста, удалите его.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Введенный сайт принадлежит не Вам. Пожалуйста, введите адрес вашего сайта.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Поле город не может быть пустым. Пожалуйста, введите Ваш город.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Введенный город уже используется. Пожалуйста, введите другой город.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Введенный город недопустим. Пожалуйста, введите другой город.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Вы ввели не свой город. Пожалуйста, введите свой город.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Название города содержит ссылку. Пожалуйста, введите свой город.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Страна не была выбрана. Пожалуйста, введите Вашу страну.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Страна выбрана неверно. Пожалуйста, попробуйте снова.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Оценка не была выбрана. Пожалуйста, введите Вашу оценку.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Оценка выбрана неверно. Пожалуйста, попробуйте снова.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Комментарий, на который вы отвечаете, недействителен. Пожалуйста, попробуйте снова.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Поле комментарий не может быть пустым. Пожалуйста, введите Ваш комментарий.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Введен слишком короткий комментарий. Пожалуйста, дополните Ваш комментарий.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Комментарий слишком длинный. Пожалуйста, введите комментарий поменьше.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Введенный комментарий содержит слишком много строк. Пожалуйста, введите меньше строк.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Введенный комментарий уже подтвержден. Пожалуйста, введите другой комментарий.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Введенный комментарий содержит слишком  много смайлов (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Данный комментарий содержит оскорбительную лексику. Пожалуйста, удалите ее.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Ругательства запрещены. Пожалуйста, удалите агрессивную лексику из Вашего комментария.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Спам запрещен. Пожалуйста, удалите спам из Вашего комментария.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Комментарий содержит слишком длинное слово. Пожалуйста, сократите либо удалите его.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Комментарий содержит слишком много заглавий.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Комментарий содержит ссылку. Пожалуйста, удалите ее.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Комментарий содержит повторяющиеся символы. Пожалуйста, удалите их.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Поле вопрос не может быть пустым. Пожалуйста, введите ответ.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Введен неверный ответ. Пожалуйста, попробуйте снова.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Пожалуйста, введите символы с картинки.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Введены неверные символы. Пожалуйста, попробуйте снова.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Ваш последний комментарий был отправлен недавно. Пожалуйста, подождите.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Вы  уже отправили несколько комментариев. Пожалуйста, подождите.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Пожалуйста, настройте Ваш браузер для отправки referrer information.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Пожалуйста, настройте Ваш браузер для поддержки максимальной длины поля.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Вы только что были забанены. Это может быть следствием различных причин, включая ругань, спам и действия, расценивающиеся как хакерство. Если Вы считаете, что произошла ошибка, пожалуйста, обратитесь к администратору, указав Ваш IP-адрес.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Извините, Вы были забанены.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Неправильный ключ.');
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Нет ключа.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'No resubmit key.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Invalid resubmit key.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Injection attempt.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Такое имя уже существует.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Введено запрещенное имя.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Такое имя недопустимо.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Имя содержит ссылку.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Адрес уже используется.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Введен запрещенный адрес.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Введен неверный адрес.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Данный сайт уже зарезервирован.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Введен запрещенный сайт.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Комментарий содержит запрещенный сайт.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Введен неверный сайт.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Введенный город уже существует.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Введенный город недопустим.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Введен неправильный город.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Город содержит ссылку.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Грубая лексика.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Нецензурная лексика.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Спам');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Слишком много заглавных букв.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Комментарий содержит ссылку.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Комментарий содержит повторы.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Approve all.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Такое имя уже существует.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Такое имя невозможно.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Имя введено неверно.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Имя содержит ссылку.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Такой адрес уже существует.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Введенный адрес запрещен.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Адрес введен неверно.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Сайт введен.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Такой сайт уже существует.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Введен запрещенный сайт.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Комментарий содержит запрещенный сайт.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Введен неверный сайт.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Такой город уже существует.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Такой город невозможен.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', ' Город введен неверно.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Название города содержит ссылку.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Комментарий содержит ссылку.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Комментарий содержит повторы.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Загружена картинка.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Загружено видео.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Грубая лексика.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Нецензурная лексика.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Спам.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Слишком много заглавных букв.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>