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

function cmtx_db_error_general() { //display a general database error to user

	echo '<h3>Commentics</h3>';
	echo '<div style="margin-bottom: 10px;"></div>';
	echo '<p>Sorry, there is a database problem.</p>';
	echo '<p>Please check back shortly. Thanks.</p>';

} //end of db-error-general function


function cmtx_db_error_connect($errno, $error) { //display a database connection error to admin

	if (defined('CMTX_IN_ADMIN')) {
		echo '<img src="images/commentics/logo.png" style="padding-bottom:15px" title="Commentics" alt="Commentics"/>';
		echo '<br />';
	}
	
	echo '<div style="background: #FCFCFC; padding: 5px; padding-bottom: 15px; padding-right: 10px; border-top: 1px solid #ABABAB; border-left: 1px solid #ABABAB; border-right: 1px solid #888888; border-bottom: 1px solid #888888; background-image: linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -o-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -moz-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -webkit-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -ms-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); box-shadow: 3px 3px 5px #888888; float:left;">';
	echo 'Sorry, there is a <span style="font-weight: bold; color: #CC0000;">database connection</span> error:';
	echo '<p></p>';
	echo '<i>' . $errno . ': ' . $error . '</i>';
	
	if ($errno == '1049' || $errno == '1102') {
		echo '<p></p>';
		echo 'This error is because the script has no database.';
		echo '<p></p>';
		echo 'The following are steps to help fix it:';
		echo '<ol style="margin-bottom:0px;">';
		echo '<li>Did you create the database?</li><br/>';
		echo '<li>Does the database still exist?</li><br/>';
		echo '<li>';
		echo '<i>(a)</i> Open the file /db/details.php';
		echo '<br/>';
		echo '<i>(b)</i> Check the value of <b>$cmtx_mysql_database</b>';
		echo '<br/>';
		echo '<i>(c)</i> Does it match with the database you created?';
		echo '</li>';
		echo '</ol>';
	}
	
	if ($errno == '1044') {
		echo '<p></p>';
		echo 'This error appears to be because your username is wrong.';
		echo '<p></p>';
		echo 'The following are steps to help fix it:';
		echo '<p></p>';
		echo '<i>(a)</i> Open the file /db/details.php';
		echo '<br/>';
		echo '<i>(b)</i> Check the value of <b>$cmtx_mysql_username</b>';
		echo '<br/>';
		echo '<i>(c)</i> Does it match with your MySQL username?';
	}
	
	if ($errno == '1045') {
		echo '<p></p>';
		echo 'This error appears to be because your password is wrong.';
		echo '<p></p>';
		echo 'The following are steps to help fix it:';
		echo '<p></p>';
		echo '<i>(a)</i> Open the file /db/details.php';
		echo '<br/>';
		echo '<i>(b)</i> Check the value of <b>$cmtx_mysql_password</b>';
		echo '<br/>';
		echo '<i>(c)</i> Does it match with your MySQL password?';
	}
	
	if ($errno == '2002') {
		echo '<p></p>';
		echo 'This error appears to be because your host is wrong.';
		echo '<p></p>';
		echo 'The following are steps to help fix it:';
		echo '<p></p>';
		echo '<i>(a)</i> Open the file /db/details.php';
		echo '<br/>';
		echo '<i>(b)</i> Check the value of <b>$cmtx_mysql_host</b>';
		echo '<br/>';
		echo '<i>(c)</i> Does it match with your MySQL host?';
	}
	
	if ($errno == '0') {
		echo '<p></p>';
		echo 'This error appears to be because your port is wrong.';
		echo '<p></p>';
		echo 'The following are steps to help fix it:';
		echo '<p></p>';
		echo '<i>(a)</i> Open the file /db/details.php';
		echo '<br/>';
		echo '<i>(b)</i> Check the value of <b>$cmtx_mysql_port</b>';
		echo '<br/>';
		echo '<i>(c)</i> Does it match with your MySQL port?';
	}
	
	echo '</div>';
	echo '<div style="clear:left;"></div>';
	echo '<br/>';
	echo '<input type="button" style="background: url(\'images/buttons/gradient.gif\') repeat-x scroll 0 100% #FFAC47; border-color: #ED6502 #A04300 #A04300 #ED6502; border-style: solid; border-width: 1px; color: #FFFFFF; cursor: pointer; font: bold 12px arial,helvetica,sans-serif; padding: 1px 7px 2px; text-align: center !important; white-space: nowrap; margin-right: 2px;" name="refresh" title="Refresh" value="Refresh" onclick="window.location.reload()"/>';

} //end of db-error-connect function


function cmtx_db_error_details() { //display a database details error to admin

	echo '<img src="images/commentics/logo.png" style="padding-bottom:15px" title="Commentics" alt="Commentics"/>';
	echo '<br />';
	echo '<div style="background: #FCFCFC; padding: 5px; padding-right: 10px; border-top: 1px solid #ABABAB; border-left: 1px solid #ABABAB; border-right: 1px solid #888888; border-bottom: 1px solid #888888; background-image: linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -o-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -moz-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -webkit-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -ms-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); box-shadow: 3px 3px 5px #888888; float:left;">';
	echo 'Sorry, there is a <span style="font-weight: bold; color: #CC0000;">database details</span> problem.';
	echo '<p></p>';
	echo '<u>If you haven\'t yet installed the programme</u>';
	echo '<ul>';
	echo '<li>You need to run the installer</li>';
	echo '</ul>';
	echo '<p></p>';
	echo '<u>If you have already installed the programme</u>';
	echo '<ul>';
	echo '<li>Check that /db/details.php exists</li>';
	echo '</ul>';
	echo '</div>';
	echo '<div style="clear:left;"></div>';
	echo '<br/>';
	echo '<input type="button" style="background: url(\'images/buttons/gradient.gif\') repeat-x scroll 0 100% #FFAC47; border-color: #ED6502 #A04300 #A04300 #ED6502; border-style: solid; border-width: 1px; color: #FFFFFF; cursor: pointer; font: bold 12px arial,helvetica,sans-serif; padding: 1px 7px 2px; text-align: center !important; white-space: nowrap; margin-right: 2px;" name="refresh" title="Refresh" value="Refresh" onclick="window.location.reload()"/>';

} //end of db-error-details function


function cmtx_db_error_table() { //display a database tables error to admin

	echo '<img src="images/commentics/logo.png" style="padding-bottom:15px" title="Commentics" alt="Commentics"/>';
	echo '<br />';
	echo '<div style="background: #FCFCFC; padding: 5px; padding-right: 10px; border-top: 1px solid #ABABAB; border-left: 1px solid #ABABAB; border-right: 1px solid #888888; border-bottom: 1px solid #888888; background-image: linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -o-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -moz-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -webkit-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); background-image: -ms-linear-gradient(top, #FFFFFF 1%, #F5F5F5 65%); box-shadow: 3px 3px 5px #888888; float:left;">';
	echo 'Sorry, there is a <span style="font-weight: bold; color: #CC0000;">database tables</span> problem.';
	echo '<p></p>';
	echo 'The following are steps to help fix it:';
	echo '<ul>';
	echo '<li>Open the file /db/details.php</li>';
	echo '<li>Is the <b>$cmtx_mysql_table_prefix</b> value correct?</li>';
	echo '<li>Using <i>phpMyAdmin</i>, check that the tables exist.</li>';
	echo '</ul>';
	echo '</div>';
	echo '<div style="clear:left;"></div>';
	echo '<br/>';
	echo '<input type="button" style="background: url(\'images/buttons/gradient.gif\') repeat-x scroll 0 100% #FFAC47; border-color: #ED6502 #A04300 #A04300 #ED6502; border-style: solid; border-width: 1px; color: #FFFFFF; cursor: pointer; font: bold 12px arial,helvetica,sans-serif; padding: 1px 7px 2px; text-align: center !important; white-space: nowrap; margin-right: 2px;" name="refresh" title="Refresh" value="Refresh" onclick="window.location.reload()"/>';

} //end of db-error-table function
?>