<?php
// Hit counter function.
// Your probably want to remove lines that report errors. If not your website could stop working if, for example, your database is down.

include ('counter_config.php');
echo "hi";
function addinfo($page)

{ 
	
// ################################################
// ######### connect + select  database ###########
// ################################################

	global $localhost,$dbuser, $dbpass, $dbname, $dbtablehits1,$dbtableinfo1,$maxrows; 

	$link = mysql_connect($localhost, $dbuser, $dbpass); 
	
	if (!$link) 
	{
	    die('Could not connect: ' . mysql_error());  // remove ?
	}	

	$dbselect=mysql_select_db($dbname); 
	if (!$dbselect) 
	{
    	die ("Can't use database $dbname! : " . mysql_error()); // remove ?
	}
	
// ########################################################
// ######### check if counter exsist and update ###########
// ########################################################

	if(mysql_num_rows(mysql_query("SELECT page FROM $dbtablehits1 WHERE page = '$page'")))
	{
	//A counter for this page  already exsists. Now we have to update it.

		$updatecounter = mysql_query("UPDATE $dbtablehits1 SET count = count+1 WHERE page = '$page'");
		if (!$updatecounter) 
		{
		die ("Can't update the counter : " . mysql_error()); // remove ?
		}
	
	} 
	else
	{
	// This page did not exsist in the counter database. A new counter must be created for this page.

		$insert = mysql_query("INSERT INTO $dbtablehits1 (page, count)VALUES ('$page', '1')");
	
		if (!$insert) 
		{
    		die ("Can\'t insert into $dbtablehits : " . mysql_error()); // remove ?
		}
	}
	
// ####################################################
// ######### add IP and user-agent and time ###########
// ####################################################
// gather user data
$id= $_POST["id"]; 
$name=$_POST["name"];
$datetime =date("Y/m/d") . ' ' . date('H:i:s') ;

if(!mysql_num_rows(mysql_query("SELECT id FROM info1 WHERE id = '$id'"))) // check if the IP is in database
 {
	// if not , add it.	
	$adddata = mysql_query("INSERT INTO $dbtableinfo1 (id, name, datetime) VALUES('$id' ,'$name','$datetime')");
	if (!$adddata) 
	{
	    die('Could not add IP : ' . mysql_error()); // remove ?
	}
}

// ***************************************************************
// ** delete the first entry in $dbtableinfo if rows > $maxrows **
// ***************************************************************

/*$result = mysql_query("SELECT * FROM $dbtableinfo", $link);
$num_rows = mysql_num_rows($result);
$to_delete = $num_rows- $maxrows;
if($to_delete > 0)
{
	for ($i = 1; $i <= $to_delete; $i++) 
	{

		$delete = mysql_query("DELETE FROM $dbtableinfo ORDER BY id LIMIT 1") ;
		if (!$delete) 
		{
		    die('Could not delete : ' . mysql_error()); // remove ?
		}
	}
}	

mysql_close($link);

} 
*/
}
?>
