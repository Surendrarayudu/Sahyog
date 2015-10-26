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
cmtx_define('CMTX_COMMENTS_HEADING', 'Commentaires');

/* No comments message */
cmtx_define('CMTX_NO_COMMENTS', 'Pas encore de commentaires.');

/* Sort By */
cmtx_define('CMTX_SORT_TEXT', 'Sort');
cmtx_define('CMTX_SORT_TITLE', 'Trier les commentaires');
cmtx_define('CMTX_SORT_1', 'Récent');
cmtx_define('CMTX_SORT_2', 'Ancien');
cmtx_define('CMTX_SORT_3', 'Utiles');
cmtx_define('CMTX_SORT_4', 'Inutiles');
cmtx_define('CMTX_SORT_5', 'Positive');
cmtx_define('CMTX_SORT_6', 'Critique');

/* Topic */
cmtx_define('CMTX_TOPIC_INTRO', 'Vous commentez');

/* Average Rating */
cmtx_define('CMTX_RATE_NO_PAGE', 'This page no longer exists');
cmtx_define('CMTX_RATE_ALREADY_RATED', 'You\'ve already rated');
cmtx_define('CMTX_RATE_BANNED', 'You\'ve been banned');

/* Says */
cmtx_define('CMTX_SAYS', 'a écrit...');

/* Read More */
cmtx_define('CMTX_READ_MORE', '... Lire la suite');
cmtx_define('CMTX_TITLE_READ_MORE', 'Lire le commentaire complet');

/* Admin Reply */
cmtx_define('CMTX_REPLY_INTRO', 'Admin:');

/* Date */
cmtx_define('CMTX_TODAY', 'Aujourd\'hui');
cmtx_define('CMTX_YESTERDAY', 'Hier');

/* Like Dislike */
cmtx_define('CMTX_TITLE_LIKE', 'Augmenter le vote de ce commentaire');
cmtx_define('CMTX_TITLE_DISLIKE', 'Diminuer le vote pour ce commentaire');
cmtx_define('CMTX_VOTE_NO_COMMENT', 'Ce commentaire a été supprimé');
cmtx_define('CMTX_VOTE_OWN_COMMENT', 'Vous ne pouvez pas voter pour votre propre commentaire');
cmtx_define('CMTX_VOTE_ALREADY_VOTED', 'Vous avez déjà voté ce commentaire');
cmtx_define('CMTX_VOTE_BANNED', 'Vous avez déjà été banni');

/* Flag */
cmtx_define('CMTX_FLAG', 'Signaler');
cmtx_define('CMTX_TITLE_FLAG', 'Signaler ce commentaire');
cmtx_define('CMTX_FLAG_DIALOG_HEADING', 'Report Comment');
cmtx_define('CMTX_FLAG_DIALOG_CONTENT', 'Êtes-vous sûr de vouloir à signaler ce commentaire?');
cmtx_define('CMTX_FLAG_DIALOG_YES', 'Yes');
cmtx_define('CMTX_FLAG_DIALOG_NO', 'No');
cmtx_define('CMTX_FLAG_NO_COMMENT', 'Ce commentaire a été supprimé');
cmtx_define('CMTX_FLAG_OWN_COMMENT', 'Vous ne pouvez pas déclarer votre propre commentaire');
cmtx_define('CMTX_FLAG_ADMIN_COMMENT', 'You cannot report an admin comment');
cmtx_define('CMTX_FLAG_BANNED', 'Vous avez déjà été banni');
cmtx_define('CMTX_FLAG_REPORT_LIMIT', 'Vous ne pouvez pas déclarer plus des commentaires');
cmtx_define('CMTX_FLAG_ALREADY_REPORTED', 'Vous avez déjà signalé ce commentaire');
cmtx_define('CMTX_FLAG_ALREADY_FLAGGED', 'Ce commentaire a déjà été signalé');
cmtx_define('CMTX_FLAG_ALREADY_VERIFIED', 'Ce commentaire a déjà été vérifiée');
cmtx_define('CMTX_FLAG_REPORT_SENT', 'Je vous remercie pour le rapport');

/* Permalink */
cmtx_define('CMTX_PERMALINK', 'Permalink');
cmtx_define('CMTX_TITLE_PERMALINK', 'Permalink for this comment');

/* Reply */
cmtx_define('CMTX_REPLY', 'Réponse');
cmtx_define('CMTX_TITLE_REPLY', 'Répondre à ce commentaire');

/* RSS */
cmtx_define('CMTX_RSS', 'RSS Alerts');
cmtx_define('CMTX_TITLE_RSS', 'Get RSS alerts for this page');

/* Page Number */
cmtx_define('CMTX_INFO_PAGE', 'Page %d de %d');

/* Pagination */
cmtx_define('CMTX_PAGINATION_FIRST', 'première');
cmtx_define('CMTX_PAGINATION_PREVIOUS', '<');
cmtx_define('CMTX_PAGINATION_NEXT', '>');
cmtx_define('CMTX_PAGINATION_LAST', 'dernière');
cmtx_define('CMTX_TITLE_PAG_FIRST', 'première');
cmtx_define('CMTX_TITLE_PAG_PREVIOUS', 'précédente');
cmtx_define('CMTX_TITLE_PAG_NEXT', 'prochaine');
cmtx_define('CMTX_TITLE_PAG_LAST', 'dernière');

?>