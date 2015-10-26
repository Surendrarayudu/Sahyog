<?php

//############################################################################
//##### run this file to create the tables needed for the counter to work #### 
//############################################################################

 include ('counter_config.php');

$link = mysql_connect("$localhost", "$dbuser", "$dbpass");
if (!$link) 
{
    die('Could not connect: ' . mysql_error());
}

echo "- Connected to database at $localhost successfully <br />";

$db_selected = mysql_select_db($dbname, $link);
if (!$db_selected) 
{
    die ("Can't use database $dbname! : " . mysql_error());
}

echo "- Using database $dbname <br />" ;


$create1 = mysql_query("CREATE TABLE IF NOT EXISTS $dbtableinfo1(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), name VARCHAR(50), datetime VARCHAR(25))");
if (!$create1) 
{
    die("Could create table $dbtableinfo1 :" . mysql_error());
}

echo "- Table $dbtableinfo1 created.<br />";

$create2 = mysql_query("CREATE TABLE IF NOT EXISTS $dbtablehits1(page char(100),PRIMARY KEY(page),count int(15))");
if (!$create2) 
{
    die("Could create table $dbtablehits1 :" . mysql_error());
} 

echo "- Table $dbtablehits1 created<br/>";


mysql_close($link);

echo '- You are now ready to start using the statscounter.';

?>

