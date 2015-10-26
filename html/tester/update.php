<?php
$con = mysql_connect("localhost","root","sahyog");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
mysql_select_db("serengne", $con);
 
$edit=mysql_query("update ipadrs SET centername='$_POST[cname]',ipadress='$_POST[ipadrs]',username='$_POST[uname]',dept='$_POST[dpname]',status='$_POST[stats]',machinename='$_POST[mname]' where id = $_POST[id]");

 if (!mysql_query($edit,$con))
  {
  die('Error: ' . mysql_error());
  }
  echo "After updated"."<br>";
include("upshow.php");
 mysql_close($con);
?>
