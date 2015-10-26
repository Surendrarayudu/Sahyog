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
cmtx_define('CMTX_ERROR_NUMBER', 'Spiacente ma %d è stato trovato errore durante l\'elaborazione il tuo commento.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Spiacente ma %d è stato trovato errore durante l\'elaborazione il tuo commento.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Correggi questo errore e re-invia il form:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Correggi questo errore e re-invia il form:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Solo anteprima');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Grazie.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Il tuo commento è in attesa di approvazione.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Grazie.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Il tuo commento è stato aggiunto.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Il campo nome non può essere vuoto. Inserisci il tuo nome.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Solo un nome può essere inserito in questo campo. Inserisci un nome.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Il nome inserito è riservato. Scegliere un altro.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Il nome inserito è vietato. Scegliere un altro.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Il nome inserito non è tuo. Per favore inserisci il tuo nome.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Il nome immesso contiene un link. Per favore inserisci solo il nome.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Il campo e-mail non può essere vuoto. Inserisci il tuo indirizzo.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'L\'indirizzo e-mail inserito non è corretto. Verifica il tuo inserimento.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'L\'indirizzo email inserito è riservato. Inserisci il tuo indirizzo email.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'L\'indirizzo email inserito è vietato. Inserisci un altra email.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'L\'indirizzo e-mail inserito non è tuo. Inserisci il tuo indirizzo email.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Il campo sito web non può essere vuoto. Inserisci il tuo sito web.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'L\'indirizzo del sito inserito non è corretto. Controllail tuo inserimento.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'L\'indirizzo del sito web inserito è riservato. Inserisci il tuo sito.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'L\'indirizzo del sito web inserito è vietato. Si prega di rimuoverlo.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'L\'indirizzo del sito web nel tuo commento è vietato. Si prega di rimuoverlo.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'L\'indirizzo del sito inserito non è tuo. Inserisci il tuo sito web.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Il campo città non può essere vuoto. Inserisci la tua città.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'La città inserita è riservata. Si prega di inserirne un\'altra.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'La città inserita è riservata. Si prega di inserirne un\'altra.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'La città inserita non è la tua. Inserisci la tua città.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'La città contiene un link. Inserisci la tua città.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Il campo Paese non è stato selezionato. Seleziona il tuo paese.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Il paese selezionato non è valido. Si prega di contattare l\'amministratore.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Il campo rating non è stato selezionato. Fai la tua valutazione.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Il rating selezionato non è valido. Si prega di contattare l\'amministratore.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Il commento a cui stai rispondendo non è valido. Riprova.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Il campo di commento non può essere vuoto. Inserisci un commento.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Il commento immesso è stato troppo breve. Inserisci un commento più lungo.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Il commento immesso è troppo lungo. Inserisci un breve commento.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Il commento immesso contiene troppe righe. Inserisci il minor numero di linee.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Hai già inviato questo commento. Si prega di inviare uno nuovo.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Il commento immesso contiene troppe faccine (Max: %d).');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Il commento immesso contiene parole offensive. Si prega di rimuovere queste parole.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Offendere non è permesso. Si prega di rimuovere le parolacce dal tuo commento.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Lo spamming non è permesso. Si prega di rimuovere lo spam dal tuo commento.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Il commento contiene una parola troppo lunga. Si prega di rimuovere questa parola.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Il commento inserito contiene troppe MAIUSCOLE. Inserisci il minor numero di maiuscole.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Il commento immesso contiene un link. Si prega di rimuoverlo.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Il commento inserito contiene caratteri ripetuti. Si prega di rimuoverli.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Il campo non può essere vuoto. Inserisci la risposta.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'La risposta alla domanda non era corretta. Riprova.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Il campo captcha non può essere vuoto. Inserisci i caratteri.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'I caratteri del captcha non sono corretti. Riprova.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Il tuo ultimo commento è stato inserito di recente. Si prega di aspettare più a lungo.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Inseriti diversi commenti di recente. Aspetta un poco.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Si prega di abilitare il browser web per l\'invio di informazioni.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'Il riferimento che hai inviato proviene da un altro sito.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Si prega di abilitare il browser Web per rispettare la lunghezza massima del campo.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'Un campo nascosto, utilizzato per rilevare i bot, è stato riempito. Si prega di lasciarlo vuoto.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'Il modulo è stato inviato troppo in fretta. Si prega di procedere più lentamente.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Mancano alcuni dati attesi. Si prega di inviare nuovamente il form.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Sei appena stato bandito. Questo può essere dovuto a una serie di motivi tra cui offese, spamming e comportamenti relativi all\'hacking. Se ritieni che questo sia un errore, contatta l\'amministratore del sito, indicando il tuo indirizzo IP.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Siamo spiacenti, sei stato precedentemente bandito.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Nessuna chiave di sicurezza.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Chiave di sicurezza non corretta.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'Nessuna chiave ripresentata.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Chiave non valida.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Tentativo di intrusione.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Immesso Nome riservato.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Immesso Nome Bannato.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Immesso Nome fittizio.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link inserito nel nome.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Immesso indirizzo di posta elettronica riservato.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Indirizzo e-mail inserito bannato.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Indirizzo di posta elettronica fittizio.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Indirizzo web riservato.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Inserito Sito vietato.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Sito vietato nel commento.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Indirizzo web fittizio.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Inserita Città Riservata.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Inserita Città proibita.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Inserita Città fittizia.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link in città.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Imprecazione lieve.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Imprecazione forte.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Troppe lettere maiuscole.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link inserito nel commento.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Ripetizioni inserite nel commento.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Approvato tutto.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Immesso Nome riservato.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Immesso Nome vietato.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Immesso Nome fittizio.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link inserito nel nome.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Immesso indirizzo di posta elettronica riservato.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'L\'Indirizzo e-mail inserito è vietato.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Indirizzo di posta elettronica è fittizio.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Inserito sito Web.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Inserito sito Web riservato.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Inserito sito Web vietato.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Sito vietato inserito nel commento.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Inserito indirizzo web fittizio.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Inserita Città Riservata.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Inserita Città vietata.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Inserita Città fittizia.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link nella Città inserita.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Inserito Link.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Inserimenti ripetuti.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Immagine inserita.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video inserito.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Imprecazione lieve.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Imprecazione forte.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Troppe lettere maiuscole.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>