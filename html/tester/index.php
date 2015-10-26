<html>
<head>
</head>
<body>
<table align="center" height="100" width="100">
<tr><td></td></tr>
</table>
<?php
error_reporting(0);
$con=mysql_connect("localhost","root","sahyog"); 
$select=mysql_select_db("serengne");
$a=$_POST["abc"];
$b=$_POST["xyz"];
?>
<!--<h1><center><font color="#3300CC">ADMIN PANEL</font></center> </h1>-->

<form action="" method="post">
<table align="center" border=""  height="200" width="400">
<tr><td><img src="Login.jpg" height="200" width="250"></td><td><font face="Arial, Helvetica, sans-serif" size="+3" style="color:#00F">ADMIN PANEL </font></td></tr>
<tr><td><font color="#0000FF" size="+3">Username</font></td><td><input type="text" name="abc" /></td></tr>
<tr><td><font color="#0000FF" size="+3">Password</font></td><td><input type="password" name="xyz" /></td></tr>
<tr><td colspan="2"><center><input type="submit" name="LOGIN" value="LOGIN" style="font-size:30px; color:#00F"/></center></td></tr>
</table>
</form>
<?php
if(isset($_POST['LOGIN']))
{
	$sel=mysql_query("select * from admin where username='$a' and pswd='$b'");
	if(mysql_num_rows($sel)==1)
	{
		$r=mysql_fetch_array($sel);
		session_start();
		$_SESSION['user']=$r['username'];
		header("location:home.php");
	}
	else
{
echo"<font size='+3' color='#FF0000'> Username Or Password Incorrect</font>";
}

}
?>
</body>