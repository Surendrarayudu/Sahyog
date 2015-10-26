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


function cmtx_delete_replies($id) { //delete replies of comment
	
	global $cmtx_mysql_table_prefix;
	
	$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '$id'");
	
	while ($comments = cmtx_db_fetch_assoc($query)) {
	
		$id = $comments["id"];
	
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "voters` WHERE `comment_id` = '$id'");
		cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "reporters` WHERE `comment_id` = '$id'");
	
		cmtx_delete_replies($id);
	
	}

} //end of delete-replies function


//delete comments older than the configured time period
$query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `dated` < DATE_SUB(NOW(), INTERVAL " . cmtx_setting('days_to_delete_comments') . " DAY)"); //select comments to delete


while ($comments = cmtx_db_fetch_assoc($query)) { //while there are comments to delete

	$id = $comments["id"]; //get the ID of the comment
	
	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'"); //delete it
	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "voters` WHERE `comment_id` = '$id'"); //delete its voters
	cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "reporters` WHERE `comment_id` = '$id'"); //delete its reporters

	cmtx_delete_replies($id); //delete its replies
	
}

?>