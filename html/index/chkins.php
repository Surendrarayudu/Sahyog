<?php 
	include("connect.php");
//include ('counter_config.php');

	$conn = mysql_connect("$servername","$username", "$password");
	if (!$conn) 
	{
    die('Could not connect: ' . mysql_error());
	}
	echo "Connected to database at $localhost successfully <br />";

	$db_selected = mysql_select_db($dbname, $conn);
	if (!$db_selected) 
	{
    die ("Can't use database $dbname! : " . mysql_error());
	}
	echo "- Using database $dbname <br />" ;

// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$id=$_POST['id'];
	$name= $_POST['name'];
  //$count = $_POST['count'];
  //$users_name = mysql_real_escape_string($users_name);
  //$users_email = mysql_real_escape_string($users_email);
  
 /* $id = $_GET['id'];
  if( ! is_numeric($id) )
    die('invalid  id');*/
	
 	$query = "INSERT INTO ins (`id`,`name`)VALUES('$id','$name');";

  	mysql_query($query);

  	echo "<h2>Thank you for insertion!!!</h2>";

  	mysql_close($conn);


?>