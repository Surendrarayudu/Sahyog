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
cmtx_define('CMTX_ERROR_NUMBER', 'Žao nam je, ali %d greška otkrivenih je za vrijeme obrade vašeg komentara.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Žao nam je, ali %d greška otkrivenih je za vrijeme obrade vašeg komentara.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Molimo ispravite grešku i pošaljite ponovo:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Molimo ispravite greške i pošaljite ponovo:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Samo pregled');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Hvala.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Vaš komentar čeka odobrenje.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Hvala.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Vaš komentar je dodan.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Polje \'Naziv\' ne može biti prazno. Molimo unesite svoje ime.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Polje \'Naziv\' uzima samo jednu riječ. Molimo unesite svoje ime.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Upisano ime je rezervirana riječ. Molimo odaberite drugo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Upisano ime je zabranjena riječ. Molimo odaberite drugo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Upisano ime nije vaše. Molimo unesite svoje pravo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'U upisanom imenu je link. Molimo unesite svoje pravo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Polje \'E-mail\' ne može biti prazno. Molimo unesite adresu e-pošte.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Upisana e-mail adresa nije valjana. Molimo provjerite unos.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Upisana e-mail adresa je rezervirana. Molimo unesite drugu e-mail adresu.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Upisani e-mail je zabranjen. Molimo unesite drugu e-mail adresu.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Upisani e-mail nije vaš. Molimo unesite vašu e-mail adresu.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Polje web stranice ne može biti prazno. Molimo unesite vašu web stranicu.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Web adresa nije valjana. Molimo provjerite unos.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Web adresa je rezervirana. Molimo unesite vašu web stranicu.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Web adresa je zabranjena. Molimo da ju uklonite.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Web adresa u vašem komentaru je zabranjena. Molimo da ju uklonite.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Web adresa nije vaša. Molimo unesite vašu web stranicu.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Polje \'Grad\' ne može biti prazno. Molimo unesite svoje mjesto.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Ime grada je rezervirano. Molimo unesite drugi grad.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Ime grada je zabranjeno. Molimo unesite drugi grad.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Upisani grad nije vaš. Molimo unesite vaš grad.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'U upisanom imenu grada je link. Molimo unesite vaš grad.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Država nije odabrana. Molimo odaberite svoju državu.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Odabrana zemlja ne vrijedi. Molimo pokušajte ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Ocjena nije odabrana. Molimo odaberite ocjenu.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Odabrana Ocjena je nevažeći. Molimo pokušajte ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Komentar, na kojeg odgovarate, nije točan. Molimo pokušajte ponovo.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Polje za komentar ne može biti prazno. Molimo unesite komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Prekratak komentar. Molimo unesite duži komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Predugi komentar. Molimo skratite komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Komentar ima previše redaka. Upotrebite manje redaka.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Taj komentar već je bio poslan. Molimo upišite svoj komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Komentar sadrži previše smajlića (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Komentar sadrži neprikladan jezik. Molim vas da uklonite uvredljive riječi.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Psovanje nije dopušteno. Molimo vas da uklonite psovke iz svog komentara.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Spam nije dopušten. Molimo vas da uklonite spam iz vašeg komentara.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Komentar sadrži dugu riječ. Skratite ili uklonite tu riječ.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Komentar sadrži jako mnogo velikih slova. Molimo vas da koristite više malih slova.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'U upisanom komentaru je link. Molimo uklonite link.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Komentar sadrži ponavljajuće znakove. Molimo uklonite ih.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Polje pitanja ne može biti prazno. Molimo unesite odgovor.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Odgovor na pitanje je netočan. Molimo pokušajte ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', '\'Captcha\' polje ne može biti prazno. Molimo unesite znakove.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Znakovi sa captcha slike su netočni. Molimo pokušajte ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Vaš zadnji komentar je bio podnesen nedavno. Molimo pričekajte neko vrijeme.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Nedavno ste poslali nekoliko komentara. Molimo pričekajte neko vrijeme.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Molimo omogućite u vašem browseru kako bi slao identifikaciju.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'Prema refereru ovaj komentar ste poslali iz druge web stranice.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Molimo omogućite poštivanje ​​maksimalne duljine polja u vašem web pregledniku.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'Skriveno polje, koje se koristi za otkrivanje robota, bilo je ispunjeno. Molimo ostavite prazno.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'Komentar je dostavljen prebrzo nakon prethodnog. Molimo sačekajte duže.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Neki od očekivanih podataka nedostaju. Molimo ponovo podnesite popunjen obrazac.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Upravo smo vas blokirali. Razlozi variraju, uključujući psovanje, spam i zlonamjerno ponašanje, kao što je hekanje. Ako smatrate da je to pogreška, molimo vas da se obratite administratoru, citirajući vašu IP adresu.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Žao nam je, bili ste blokirani.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Nedostaje sigurnosni ključ.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Neispravan sigurnosni ključ.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'U ponovnog pošiljanja falio je sigurnosni ključ.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Nevaljan sigurnosni ključ.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Injection pokušaj.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Upisano pridržano ime.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Upisano blokirano ime.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Upisano ime bez sadržaja.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link u imenu.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Pridržana e-pošta.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'E-mail je blokiran.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'E-mail bez sadržaja.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Pridržana web adresa.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Blokiran URL u polju \'Web stranica\'.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran URL upisan u komentaru.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Web adresa bez sadržaja.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Ime grada je rezervirano.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Ime grada je blokirano.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Naziv grada bez sadržaja.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Kao naziv grada se koristi link.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Blage psovke.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Jake psovke.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Previše velikih slova.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link u komentaru.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Ponavljanje u komentaru.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Potvrditi sve.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Pridržano ime.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Upisano blokirano ime.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Upisano ime bez sadržaja.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link u imenu.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Pridržana e-mail adresa.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Blokirana e-mail adresa.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'E-mail adresa bez sadržaja.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Web stranica unesena.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Pridržana web adresa.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Blokiran URL u polju \'Web stranica\'.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran URL upisan u komentaru.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Ime grada bes sadržaja.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Zabranjeno ime grada.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Uneseno blokirano ime grada.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Naziv grada bez sadržaja.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link kao ime grada.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link u komentaru');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Ponavljanje u komentaru.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Unesena slika.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Unesen video.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Blage psovke.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Jake psovke.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Previše velikih slova.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>