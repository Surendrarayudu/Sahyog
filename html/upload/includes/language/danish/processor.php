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
cmtx_define('CMTX_ERROR_NUMBER', 'Der opstod %d fejl ved behandling af din kommentar.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Der opstod %d fejl ved behandling af din kommentar.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Ret fejlen og prøv igen:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Ret fejlene og prøv igen:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Smugkig, ikke indsendt!');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Tak.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Din kommentar afventer godkendelse.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Tak.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Din kommentar er tilføjet.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Navnefeltet skal udfyldes, indtast dit navn.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Du kan kun angive et enkelt navn i navnefeltet.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Det indtastede navn benyttes allerede af en anden. Angiv et andet navn.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Det indtastede navn er ikke tilladt at bruge her. Indtast et andet navn.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Du har indtastet et falsk navn. Indtast dit tigtige navn.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Navnet indeholder et link. Indtast dit rigtige navn uden link.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Mailfeltet skal udfyldes. Indtast din mailadresse.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Du har indtastet en ugyldig mailadresse. Tjek den indtastede adresse for fejl.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Den indtastede mailadresse er reserveret. Indtast din mailadresse.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Den indtastede mailadresse er ikke tilladt. Indtast en anden adresse.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Den indtastede mailadresse er ikke din egen. Indtast din mailadresse.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Hjemmesidefeltet skal udfyldes. Indtast adressen til din hjemmeside.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Den indtastede hjemmesideadresse ugyldig. Tjek den indtastede adresse for fejl.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Den indtastede hjemmesideadresse er reserveret. Indtast din hjemmesideadresse.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Den indtastede hjemmesideadresse er ikke tilladt. Indtast en anden adresse.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Den indtastede hjemmesideadresse i din kommentar er ikke tilladt her.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Den indtastede hjemmesideadresse er ikke din egen. Indtast din hjemmesideadresse.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Byfeltet skal udfyldes. Indtast din by');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Det indtastede bynavn kan ikke bruges. Indtast en anden by.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Det indtastede bynavn er ikke tilladt. Indtast en anden by.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Det indtastede bynavn er ikke din by. Indtast din egen by.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Bynavnet indeholder et link. Indtast navnet uden link.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Du skal vælge land.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Det valgte land er ugyldigt. Kontakt administrator.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Karakterfeltet var ikke valgt. Vælg din karakter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Den valgte karakter er ugyldig. Kontakt administrator.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Du har svaret på en ugyldig kommentar. Prøv igen.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Kommentarfeltet skal udfyldes. Indtast en kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Din kommentar er for kort. Indtast en længere kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Din kommentar er for lang. Indtast en kortere kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Der er for mange linjer i din kommentar. Indtast færre linjer.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Du har allerede indsendt denne kommentar. Indsend en ny kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Din kommentar indeholder for mange smilies. Maksimum er %d smilies.');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Din kommentar indeholder anstødelige ord. Slet de anstødelige ord.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Det er ikke tilladt at bruge bandeord. Slet bandeordene fra din kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Det er ikke tilladt at spamme. Slet spam fra din kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Din kommentar indeholder et ord, der er for langt. Forkort ordet.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Din kommentar indeholder for mange store bogstaver. Anvend færre store bogstaver.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Din kommentar indeholder et link. Fjern linket.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Din kommentar indeholder gentagne tegn. Fjern de gentagne tegn.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Spamfælden skal udfyldes. Indtast et svar.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Du indtastede et forkert svar i spamfælden. Prøv igen.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Captcha-feltet skal udfyldes. Indtast captcha.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Du indtastede en forkert captcha. Prøv igen.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Der skal være længere pause mellem indsendelse af kommentarer. Vent et øjeblik og prøv så igen.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Du har indsendt flere kommentarer på kort tid. Vent  lidt, før du indsender en ny kommentar.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Skift indstilling i din browser, så den medsender referrer-info.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'Den medsendte referrer antyder, at du har indsendt formularen fra en fremmed hjemmeside.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Din browser respekterer ikke den maksimale feltlængde.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'Et skjult felt blev udfyldt. Det skal være tomt.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'Formularen blev sendt for hurtigt. Brug længere tid.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Nogle forventede data manglede. Prøv at sende formularen igen.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Du er blevet spærret. Dette kan skyldes forskellige årsager, heriblandt bandeord, spamming og hacker-agtig opførsel. Hvis du mener, at dette er en fejl, så kontakt administrator med oplysning om din IP-adresse.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Du er tidligere blevet spærret.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Ingen sikkerhedsnøgle.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Forkert sikkerhedsnøgle.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'Ingen gensend-tast.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Ugyldig gensend-tast.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Forsøg på injection.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Indtastning af reserveret navn.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Indtastning af spærret navn.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Indtastning af ugyldigt navn.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Brug af link i navn.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Indtastning af reserveret mailadresse.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Indtastning af spærret mailadresse.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Indtastning af ugyldig mailadresse.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Indtastning af reserveret hjemmesideadresse.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Indtastning af spærret hjemmesideadresse.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Indtastning af spærret hjemmesideadresse i en kommentar.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Indtastning af ugyldig hjemmesideadresse.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Indtastning af reserveret bynavn.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Indtastning af spærret bynavn.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Indtastning af ugyldigt bynavn.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Brug af link i bynavnet.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Brug af lettere bandeord.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Brug af stærke bandeord.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Brug af for mange store bogstaver.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Indtastning af link i kommentar.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Indtastning af gentagelser i kommentar.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Godkend alle.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Brug af reserveret navn.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Brug af spærret navn.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Brug af ugyldigt navn.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Brug af link i navnet.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Brug af reserveret mailadresse.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Brug af spærret mailadresse.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Brug af ugyldig mailadresse.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Brug af hjemmesideadresse.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Brug af reserveret hjemmesideadresse.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Brug af spærret hjemmesideadresse i hjemmesidefeltet.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Brug af spærret hjemmeside i en kommentar.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Brug af ugyldig hjemmesideadresse.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Brug af reserveret bynavn.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Brug af spærret bynavn.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Brug af ugyldigt bynavn.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Brug af link i bynavn.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Brug af link.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Brug af gentagne bogstaver.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Indsættelse af billede.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Indsættelse af video.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Brug af lettere bandeord.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Brug af stærke bandeord.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Brug af for mange store bogstaver.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet (spam).');

?>