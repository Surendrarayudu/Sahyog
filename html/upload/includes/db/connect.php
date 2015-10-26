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

$cmtx_db_ok = true;

require_once 'functions.php'; //load database functions
require_once 'failure.php'; //load failure messages

if (file_exists($cmtx_path . 'includes/db/details.php')) { //if database details file exists
	require_once 'details.php'; //load database details
} else {
	if (defined('CMTX_IN_ADMIN')) {
		cmtx_db_error_details();
		$cmtx_db_ok = false;
		return;
	} else {
		cmtx_db_error_general();
		$cmtx_db_ok = false;
		return;
	}
}

if (empty($cmtx_mysql_database)) {
	$cmtx_mysql_database = ' ';
}

if (empty($cmtx_mysql_port)) {
	@$cmtx_link = mysqli_connect($cmtx_mysql_host, $cmtx_mysql_username, $cmtx_mysql_password, $cmtx_mysql_database);
} else {
	@$cmtx_link = mysqli_connect($cmtx_mysql_host, $cmtx_mysql_username, $cmtx_mysql_password, $cmtx_mysql_database, $cmtx_mysql_port);
}

if (!$cmtx_link) {
	if (defined('CMTX_IN_INSTALLER') || defined('CMTX_IN_ADMIN')) {
		cmtx_db_error_connect(mysqli_connect_errno(), mysqli_connect_error());
	} else {
		cmtx_db_error_general();
	}
	$cmtx_db_ok = false;
	return;
}

if (cmtx_db_num_rows(cmtx_db_query("SHOW TABLES LIKE '" . $cmtx_mysql_table_prefix . "comments'")) == 0) {
	if (defined('CMTX_IN_ADMIN')) {
		cmtx_db_error_table();
		$cmtx_db_ok = false;
		return;
	} else if (defined('CMTX_IN_INSTALLER')) {
	} else {
		cmtx_db_error_general();
		$cmtx_db_ok = false;
		return;
	}
}

cmtx_db_set_charset();

?>