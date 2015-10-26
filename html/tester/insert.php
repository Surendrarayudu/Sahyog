<html>
<body>
<table>
<tr><td><form action="show.php" method="post"></td></tr>
<tr><td>Center Name: <input type="text" name="cname" /><br></td></tr>
<tr><td>IpAdresss: <input type="text" name="ipadrs" /><br></td></tr>
<tr><td>UserName: <input type="text" name="uname" /><br></td></tr>
<tr><td>Department: <input type="text" name="dpname" /><br></td></tr>
<tr><td>Status: <input type="text" name="stats" /><br></td></tr>
<tr><td>Machine Name: <input type="text" name="mname" /><br></td></tr>
<tr><td>Access: <input type="text" name="Access" /><br></td></tr>
<tr><td>Operation: <input type="text" name="Operation" /><br></td></tr>
<tr><td><input type="submit" name="ADD" value="ADD"></form>
 </body>
</html>  
<?php
$con = mysql_connect("localhost","root","sahyog");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
mysql_select_db("serengne", $con);
 
$sql="INSERT INTO ipadrss(centername,ipadress,username,dept,status,machinename)VALUES('$_POST[cname]','$_POST[ipadrs]',
'$_POST[uname]','$_POST[dpname]','$_POST[stats]','$_POST[mname]')";

 if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
 // echo "After inserted"."<br>";
//include("show.php");
 mysql_close($con);
?>

 