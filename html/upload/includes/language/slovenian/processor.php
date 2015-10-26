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
cmtx_define('CMTX_ERROR_NUMBER', 'Oprostite, toda %d napaka je bilo zaznana med obdelavo.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Oprostite, toda %d napak je bilo zaznanih med obdelavo.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Prosimo odpravite napako in ponovno pošljite obrazec:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Prosimo odpravite napake in ponovno pošljite obrazec:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Samo predogled');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Hvala.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Vaš komentar čaka na odobritev.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Hvala.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Vaš komentar je bil dodan.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Polje \'Ime\' ne more biti prazno. Prosimo vpišite vaše ime.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Polje \'Ime\' sprejme samo eno besedo. Prosimo vpišite vaše ime.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Vpisano ime je rezervirana beseda. Prosimo izberite drugo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Vpisano ime je prepovedana beseda. Prosimo izberite drugo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Vpisano ime ni vaše. Prosimo vpišite svoje pravo ime.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Vpisano ime vsebuje link. Prosimo vpišite svoje ime.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Polje \'E-naslov\' ne sme biti prazno. Prosimo vpišite e-naslov.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Vpisani e-naslov ni pravilen. Prosimo preverite.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Vpisani e-naslov je rezerviran. Prosimo vpišite drug e-naslov.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Vpisani e-naslov je prepovedan. Prosimo vpišite drug e-naslov.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Vpisani e-naslov ni vaš. Prosimo vpišite vaš pravi e-naslov.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Polje \'Spletna stran\' ne sme biti prazno. Prosimo vpišite vašo spletno stran.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Naslov spletne strani ni veljaven. Prosimo preverite vpis.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Naslov spletne strani je rezerviran. Prosimo vpišite drug spletni naslov.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Naslov spletne strani je prepovedan. Prosimo odstranite ga.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Naslov spletne strani v vašem komentarju je prepovedan. Prosimo odstranite ga.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Naslov spletne strani ni vaš. Prosimo vpišite resnični naslov vaše spletne strani.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Polje Mesto ne sme biti prazno. Prosimo izpolnite ga.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Rezervirano ime mesta. Prosimo vpišite drugo mesto.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Prepovedano ime mesta. Prosimo vpišite drugo mesto.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Ni vpisano ime vašega mesta. Prosimo vpišite pravo ime vašega mesta.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Vpisano ime mesta je link. Prosimo pravilno imenujte vaše mesto.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Država ni izbrana. Prosimo izberite državo.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Izbrana država je neveljavna. Prosimo, poskusite znova.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Ocena ni izbrana. Prosimo izberite jo.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Izbrana ocena je neveljavna. Prosimo, poskusite znova.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Komentar, na katerega odgovarjate, ni pravilen. Prosimo poizkusite ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Polje \'Komentar\' ne more biti prazno. Prosimo vpišite komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Prekratek komentar. Prosimo vnesite daljši komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Predolg komentar. Prosimo skrajšajte ga.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Komentar vsebuje preveč vrstic. Prosimo uporabite manj vrstic.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Vnešeni komentar je bil že poslan. Prosimo vnesite nov komentar.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Komentar vsebuje preveč smeškov (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Komentar vsebuje neprimerne besede. Prosimo odstranite jih.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Preklinjanje ni dovoljeno. Prosimo odstranite kletvice.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Spam ni dovoljen. Prosimo odstranite spam iz komentarja.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Komentar vsebuje predolgo besedo. Prosimo skrajšajte predolgo besedo ali jo odstranite.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'V komentarju je preveč velikih črk. Prosimo uporabljajte manj velikih črk.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Vpisani komentar vsebuje link. Prosimo odstranite link.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Vpisani komentar vsebuje ponavljajoče se črke. Prosimo odstranite ponavljanje.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Polje odgovora na vprašanje ne sme biti prazno. Prosimo vpišite odgovor.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Na vprašanje ste odgovorili napačno. Poizkusite znova.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Polje \'Captcha\' ne sme biti prazno. Prosimo prepišite znake s slike.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Vnešeni znaki \'Captcha\' ne ustrezajo znakom na sliki. Poizkusite ponovno.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Od zadnjega komentarja je minilo premalo časa. Nekoliko počakajte.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Komentirali ste prepogosto. Nekoliko počakajte.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Prosimo omogočite pošiljanje identifikacije vašega brskalnika.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'Referer kaže, da ste komentar oddali z druge spletne strani.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Prekoračitev količine podatkov v polju - prevelika dolžina polja.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'Skrito polje, namenjeno odkrivanju robotov, je bilo izpolnjeno. Pustite ga praznega.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'Od prejšnjega oddanega komentarja je preteklo premalo časa. Prosimo počakajte nekoliko.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Nekateri pričakovani podatki manjkajo. Prosimo vnesite podatke in ponovno pošljite komentar.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Pravkar smo vam onemogočili sodelovanje. Razlogi so lahko različni, vključno s preklinjanjem, smetenjem (Spam) in zlonamernim vedenjem, npr. hekanjem. Če menite, da po krivici, se obrnite na administratorja. Pri tem navedite vaš IP naslov.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Oprostite, bili ste izključeni.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Manjka varnostni ključ.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Nepravilen varnostni ključ.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'Ob ponovnem pošiljanju je manjkal varnostni ključ.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Napačen varnostni ključ.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Injection poizkus.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Vnešeno rezervirano ime.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Vnešeno blokirano ime.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Vnešeno ime brez vsebine (Dummy).');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link uporabljen v imenu.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Vnešen rezerviran e-mail.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Vnešen blokiran e-mail.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Vnešen e-mail brez vsebine (Dummy).');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Vnešen rezerviran spletni naslov.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Vnešen blokiran spletni naslov (polje \'Spletna stran\').');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Vnešen blokiran spletni naslov (polje \'Komentar\').');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Vnešen spletni naslov brez vsebine (Dummy).');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Vnešeno rezervirano ime mesta.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Vnešeno blokirano ime mesta.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Vnešeno ime mesta brez vsebine (Dummy).');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Kot ime mesta uporabljen je link.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Blažje preklinjanje.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Hudo preklinjanje.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Preveč velikih črk.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link v komentarju.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Ponavljanja v komentarju.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Potrditi vse.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Vnešeno je bilo rezervirano ime.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Vnešeno je bilo blokirano ime.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Vnešeno je bilo ime brez vsebine (Dummy).');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link uporabljan v imenu.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Vnešen je bil rezerviran e-naslov.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Vnešen je bil blokiran e-naslov.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Vnešeni e-naslov je brez vsebine (Dummy).');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Vnešen je bil naslov spletne strani (url).');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Vnešen je bil rezerviran spletni naslov.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Vnešen je bil blokiran spletni naslov.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran spletni naslov uporabljan v komentarju.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Vnešen je bil spletni naslov brez vsebine (Dummy).');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Vnešeno je bilo rezervirano ime mesta.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Vnešeno je bilo blokirano ime mesta.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Vnešeno je bilo ime mesta brez vsebine (Dummy).');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link je bil vnešen kot ime mesta.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link je bil vsebovan v komentarju.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Prisotna so ponavljanja v komentarju.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Vnešena je bila slika.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video je dodan.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Blažje preklinjanje.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Hudo preklinjanje.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spam - smetenje.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Preveč velikih črk.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>