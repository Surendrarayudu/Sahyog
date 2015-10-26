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
cmtx_define('CMTX_ERROR_NUMBER', 'Désolé mais %d erreur a été constatée lors du traitement de votre commentaire.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Désolé mais %d erreurs ont été constatées lors du traitement de votre commentaire.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Veuillez corriger cette erreur et soumettre à nouveau le formulaire:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Veuillez corriger ces erreurs et soumettre à nouveau le formulaire:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Aperçu seulement');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Merci.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Votre commentaire est en attente d\'approbation.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Merci.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Votre commentaire a été ajouté.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'Le champ Nom ne peut pas être vide. Veuillez entrer votre nom.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Un seul nom peut être entré pour le champ Nom. Veuillez entrer un seul nom.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Le nom entré est déjà réservé. Veuillez choisir un autre nom.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Le nom saisi est interdit. Veuillez choisir un autre nom.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Le nom entré n\'est pas le vôtre. Veuillez entrer votre vrai nom.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Le nom entré contient un lien. S\'il vous plaît entrer votre nom.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Le champ email ne peut pas être vide. Veuillez entrer votre adresse email.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'L\'adresse email saisie est incorrecte. Veuillez vérifier votre entrée.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'L\'adresse email saisie est déjà réservée. Veuillez entrer une autre adresse email.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'L\'adresse email saisie est interdite. Veuillez entrer une autre adresse email.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'L\'adresse email saisie est la vôtre. Veuillez entrer votre vraie adresse email.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Le champ Site web ne peut pas être vide. Veuillez entrer votre site web.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'L\'adresse du site web saisie semble être incorrecte. Veuillez vérifier votre entrée.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'L\'adresse du site web saisie est déjà réservée. Veuillez entrer une autre adresse site web.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'L\'adresse du site web saisie est interdite. Veuillez la supprimer.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'L\'adresse du site web dans votre commentaire est interdite. Veuillez la supprimer.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'L\'adresse du site web saisie n\'est pas la vôtre. Veuillez entrer votre vraie adresse site web.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'Le champ Ville ne peut pas être vide. Veuillez entrer votre ville.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'La ville est entré est réservé. S\'il vous plaît entrer dans une autre ville.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'La ville est entrée est interdite. S\'il vous plaît entrer dans une autre ville.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'La ville est entrée n\'est pas le vôtre. S\'il vous plaît entrer votre vraie ville.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'La ville est entré contient un lien. S\'il vous plaît entrer votre ville.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Un pays n\'a pas été sélectionné. Veuillez sélectionner votre pays.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Le pays choisi est invalide. S\'il vous plaît essayez de nouveau.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Un vote n\'a pas été sélectionné. Veuillez sélectionner un vote.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'La note sélectionnée n\'est pas valide. S\'il vous plaît essayez de nouveau.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Le commentaire que vous répondez à n\'est pas valide. S\'il vous plaît essayez de nouveau.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Le champ Commentaire ne peut pas être vide. Veuillez entrer votre commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Le commentaire entré est trop court. Veuillez entrer un plus long commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Le commentaire entré est trop long. Veuillez entrer un plus court commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Le commentaire entré contient trop de lignes. Veuillez entrer moins de lignes.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Le commentaire entré a déjà été soumis. S\'il vous plaît soumettre un commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Le commentaire entré contient trop de smileys (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Le commentaire entré contient des mots offensants. S\'il vous plaît supprimer ces mots.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Les jurons ne sont pas autorisés. Veuillez supprimer les jurons de votre commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Le spamming est interdit. Veuillez supprimer le spam de votre commentaire.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'Le commentaire entré contient un mot long. Veuillez abréger ou supprimer ce mot.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'Le commentaire entré contient trop de capitales. Veuillez entrer moins de capitales.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Le commentaire entré contient un lien. S\'il vous plaît supprimer le lien.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'Le commentaire entré contient des caractères répéter. S\'il vous plaît de les supprimer.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Le champ question ne peut pas être vide. Veuillez entrer une réponse à la question.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'La réponse à la question était incorrecte. Veuillez essayer de nouveau.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Le champ captcha ne peut pas être vide. Veuillez entrer les caractères de l\'image.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Les caractères saisis à partir de l\'image du captcha étaient incorrects. Veuillez essayer de nouveau.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Votre dernier commentaire a été soumis très récemment. Veuillez attendre un peu.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Vous avez soumis plusieurs commentaires dernièrement. Veuillez attendre un peu.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Veuillez activer votre navigateur Web pour envoyer les informations de provenance.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'S\'il vous plaît permettre à votre navigateur Web pour respecter la longueur des champs au maximum.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Vous venez d\'être banni. Cela peut être dû à une variété de raisons, y compris les jurons, le spamming et les comportements liés aux hackers. Si vous pensez que c\'était une erreur, Veuillez contacter l\'administrateur en indiquant votre adresse IP.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Désolé, vous avez été banni précédemment.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Pas de clé de sécurité.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Clé de sécurité incorrecte.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'No resubmit key.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Invalid resubmit key.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'tentative d\'injection.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Nom entré réservé.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Nom banni entré.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Nom factice entré.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link est entré dans le nom.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Adresse email réservée entrée.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Adresse email bannie entrée.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Adresse email factice entrée.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Adresse de site web réservée entrée.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Site interdit inscrit au site.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Site interdit est entré dans le commentaire.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Adresse de site web factice entrée.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'La ville est entré réservés.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Ville Banned entrée.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Ville fictive est entré.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link est entré dans la ville.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Jurons doux.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Jurons fort.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Trop de capitales.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link est entré dans le commentaire.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Répète entré dans le commentaire.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Approuver tous.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Nom réservé entré.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Nom banni entré.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nom factice entré.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link est entré dans le nom.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Adresse email réservée entrée.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Adresse email bannie entrée.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Adresse email factice entrée.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Site web entré.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Adresse de site web réservé entré.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Site interdit inscrit au site.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Site interdit est entré dans le commentaire.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Adresse de site web factice entrée.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'La ville est entré réservés.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Ville Banned entrée.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Ville fictive est entré.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link est entré dans la ville.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link est entré dans le commentaire.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Répète entré dans le commentaire.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Image entrée.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Vidéo entrée.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Jurons doux.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Jurons fort.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Spamming.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Trop de capitales.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>