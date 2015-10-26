<?php
$servername = "localhost";
$username = "root";
$password ="sahyog";
$dbname = "serengne";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$sel=mysql_query("select * from admin where id='1' ");
	//$r=mysql_fetch_array($sel);
	//$_SESSION['user']=$r["username"];
?>	

</body>
<form action="" method="post">
<table align="center" height="400" width="500">
<tr><td></td></tr>
<tr><td><font color="#0000FF" size="+3">ChangeUsername</font></td><td><input type="text" name="abc" /></td></tr>
<tr><td><font color="#0000FF" size="+3">Old Password</font></td><td><input type="password" name="xyz" /></td></tr>
<tr><td><font color="#0000FF" size="+3">New Password</font></td><td><input type="password" name="n1" /></td></tr>
<tr><td colspan="2"><center><input type="submit" name="Save" value="Save" style="font-size:24px"/></center></td></tr>
</table>
</form>
<?php
if(isset($_POST['Save']))
{
	$sel=mysql_query("select * from admin where id='1' ");
	$row=mysql_fetch_array($sel);
	$a=$_POST["abc"];
	$b=$_POST["xyz"];
	$c=$_POST['n1'];
		
		if($b==$row['2'])
		{ echo $c;
		$up=mysql_query("UPDATE admin SET username='$a' ,pswd='$c'");
		$_SESSION['user']=$row['username'];
		
		}
		
	else
	{
	echo "no change". $a .$b .$c ;
	}
	//header("location:home.php");
}
	
?>
