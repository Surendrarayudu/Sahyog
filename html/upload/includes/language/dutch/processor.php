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
cmtx_define('CMTX_ERROR_NUMBER', 'Sorry maar %d fout gevonden bij het verwerken van uw bericht.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Sorry maar %d fouten gevonden bij het verwerken van uw bericht.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Corrigeer aub de fout en voeg uw bericht dan toe:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Corrigeer aub de fouten en voeg uw bericht dan toe:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Alleen Voorbeeld');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Bedankt.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Uw bericht wacht op keuring.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Bedankt.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Uw bericht is toegevoegd.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Uw naam is verplicht. Voer aub uw naam in.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'U kunt maar 1 naam invoeren.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Deze naam is al in gebruik. Kies een andere gebruikersnaam.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Deze gebruikersnaam is verboden. Kies een andere gebruikersnaam.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Dit is niet uw gebruikersnaam. Voer uw gebruikersnaam in.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Uw gebruikersnaam bevat een link. Voer uw gebruikersnaam in.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Uw mailadres is verplicht. Voer uw mailadres in, deze wordt niet getoond.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Uw mailadres lijkt niet te kloppen. Controleer het aub.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Het mailadres is gereserveerd. Voer uw mailadres in.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Dit mailadres is verboden. Voer een ander mailadres in.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Dit is niet uw mailadres. Voer uw mailadres in.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Het veld website mag niet leeg zijn. Voer uw website in.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'De website lijkt niet te kloppen. Controleer uw invoer.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Deze website is gereserveerd. Voer aub uw website in.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Deze website is verboden. Aub verwijderen - veranderen.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'De website in uw bericht is verboden. Aub verwijderen.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Deze website is niet van u. Voer aub uw website in.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Het veld plaats mag niet leeg zijn. Voer aub uw plaats in.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Deze plaatsnaam is gereserveerd. Voer een andere plaats in.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Deze plaatsnaam is verboden. Voer een andere plaats in.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Deze plaatsnaam hoort niet bij u. Voer uw plaats in.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Uw plaatsnaam bevat een link. Voer uw plaats in.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'U heeft geen land gekozen. Kies een land.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Het geselecteerde land is ongeldig. Probeer het opnieuw.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'U heeft geen waardering gegeven. Kies uw waardering.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'De geselecteerde rating is ongeldig. Probeer het opnieuw.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Het bericht waarop u reageerd is ongeldig. Probeer het nog eens.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Het veld bericht mag niet leeg zijn. Voer een bericht in.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Uw bericht is te kort. Voer aub een langer bericht in.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Uw bericht is te lang. Kort uw bericht aub in.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Uw bericht bevat teveel regels. Probeer aub uw bericht over minder regels te maken.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Dit bericht bestaat al. Voer aub een nieuw bericht in.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Uw bericht bevat teveel smilies (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Uw bericht bevat beledigende woorden. Verwijder deze woorden.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Vloeken is niet toegestaan. Pas aub uw bericht aan.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Spamming is niet toegestaan. Verwijder de spam uit uw bericht.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Uw bericht bevat een erg lang woord. Maak aub dit woord korter of verwijder het.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Uw berciht bevat teveel hoofdletters. Gebruik minder hoofdletters.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'De ingevoerde opmerking bevat een link. Verwijder de link.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Uw bericht bevat teveel vaak terugkerende letters. Verwijder ze aub.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Het veld Vraag mag niet leeg zijn. Voer het antwoord aub in.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Het antwoord op de vraag was niet juist. Probeer het nog eens.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Het veld Captcha mag niet leeg zijn. Voer de juiste tekens in.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'De ingevoerde tekens waren niet juist. Probeer het nog eens.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'U heeft onlangs nog een bericht geplaats. Wacht aub een poosje voordat u weer plaatst.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'U heeft al meerdere berichten geplaatst. Wacht aub een poosje voordat uw weer plaatst.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Zorg ervoor dat uw browser de verwijzer informatie mee stuurt.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'De verwijzer suggereert dat je het formulier van een andere website probeerd in te dienen.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Zorg ervoor dat uw browser respecteert maximale veldlengtes.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'Een verborgen veld, gebruikt om bots te detecteren, werd ingevuld Laat het leeg.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'Het formulier is te snel ingediend. Gelieve langer duren.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Sommige verwachte data ontbrak. Gelieve nogmaals het formulier in te vullen.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'U bent geblokkeerd. Dit kan om verschillende redenen zijn. Als u denkt dat dit niet terecht is geef dan uw IP adres door aan de webmaster.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Sorry, u bent geblokkeerd.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Geen beveiligings sleutel.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Onjuiste beveiligings sleutel.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'Geen herinvoer sleutel.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Ongeldig opnieuw ingevoerde sleutel.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Injectie poging.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Gereserveerde naam ingevoerd.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Geblokkeerde naam ingevoerd.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Valse naam ingevoerd.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link ingevoerd in naam.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Gereserveerd mailadres ingevoerd.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Geblokkerd mailadres ingevoerd.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Vals email adres ingevoerd.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Gereserveerd website adres ingevoerd.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Geblokkeerd webadres ingevoerd.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Geblokkeerd webadres in bericht ingevoerd.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Nep website ingevoerd.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Gereserveerde plaats ingevoerd.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Geblokkeerde plaats ingevoerd.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Nep plaats ingevoerd.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link in plaatsnaam ingevoerd.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Mild gevloek.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Grof gevloek.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Teveel hoofdletters.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link in bericht ingevoerd.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'veel herhalingen in bericht.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Alles goedkeuren.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Gereserveerde naam ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Geblokkeerde naam ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nep naam ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link in naam ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Gereserveerd mailadres ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Geblokkeerd mail adres ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Nep mail adres ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Gereserveerd website adres ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Geblokkeerde website ingevoerd onder website.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Geblokkeerde website ingevoerd in bericht.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Nep website ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Gereserveerde plaats ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Geblokkeerde plaats ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Nep plaats ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link in plaats ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link in bericht ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Veel herhalingen in uw bericht.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Afbeelding ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video ingevoerd.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Mild vloeken.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Grof vloeken.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Teveel hoofdletters.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>