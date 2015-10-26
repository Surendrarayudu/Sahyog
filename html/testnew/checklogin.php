<?php

$host="10.59.51.201"
$username="root"
$password="sahyog"
$db_name="form"
$tbl_name="WebsiteUsers"

mysql_connect("$10.59.51.201", "$root", "$sahyog")or die("cannot connect");
mysql_select_db("$form")or die("cannot select DB");

$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword']; 

$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM $WebsiteUsers WHERE username='$harpreet' and pass='$password'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){

session_register("myusername");
session_register("mypassword");
header("location:login_success.php");
}
else {
echo "Wrong Username or Password";
}
?>