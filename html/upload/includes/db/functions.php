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

$cmtx_query_count = 0;
$cmtx_query_time = 0;
$cmtx_query_error = '';

function cmtx_db_query($query) { //executes a given query

	global $cmtx_link, $cmtx_query_count, $cmtx_query_time, $cmtx_query_error;
	
	$cmtx_query_count ++;
	
	$start = microtime(true);

	$result = mysqli_query($cmtx_link, $query);
	
	$end = microtime(true);
	
	$cmtx_query_time .= $end - $start;
	
	if (mysqli_errno($cmtx_link)) {
		$trace = debug_backtrace();
		$cmtx_query_error .= '<b>Error</b>: (' . mysqli_errno($cmtx_link) . ') ' . mysqli_error($cmtx_link) . '<br />';
		$cmtx_query_error .= '<b>Place</b>: ' . $trace[0]['file'] . ' (line ' . $trace[0]['line'] . ')<br /><br />';
	}

	return $result;

} //end of db-query function


function cmtx_db_fetch_assoc($resource) {

	$result = mysqli_fetch_assoc($resource);
	
	return $result;

} //end of db-fetch-assoc function


function cmtx_db_fetch_row($resource) {

	$result = mysqli_fetch_row($resource);
	
	return $result;

} //end of db-fetch-row function


function cmtx_db_num_rows($resource) {

	$result = mysqli_num_rows($resource);
	
	return $result;

} //end of db-num-rows function


function cmtx_db_set_charset() {

	global $cmtx_link;

	mysqli_set_charset($cmtx_link, 'utf8');

} //end of db-set-charset function


function cmtx_db_real_escape_string($value) {

	global $cmtx_link;

	$value = mysqli_real_escape_string($cmtx_link, $value);
	
	return $value;

} //end of db-real-escape-string function


function cmtx_db_get_server_info() {

	global $cmtx_link;

	$result = mysqli_get_server_info($cmtx_link);
	
	return $result;

} //end of db-get-server-info function


function cmtx_db_insert_id() {

	global $cmtx_link;

	$result = mysqli_insert_id($cmtx_link);
	
	return $result;

} //end of db-insert-id function

?>