<html>
<head>

<style>
table
{
border-style:solid;
border-width:2px;
border-color:pink;
}
</style>
</head>
<body bgcolor="#EEFDEF">
<?php
$con = mysql_connect("localhost","root","sahyog");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
mysql_select_db("serengne", $con);
 
$result = mysql_query("SELECT * FROM Form ipadrs");
 
echo "<table border='1'>
<tr>
<th>Id</th>
<th>cname</th>
<th>ipadress</th>
<th>uname</th>
<th>dpname</th>
<th>status</th>
<th>mname</th>

</tr>";
 
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['Id'] . "</td>";
  echo "<td>" . $row['cname'] . "</td>";
  echo "<td>" . $row['ipadress'] . "</td>";
  echo "<td>" . $row['uname'] . "</td>";
   echo "<td>" . $row['dpname'] . "</td>";
   echo "<td>" . $row['status'] . "</td>";
   echo "<td>" . $row['mname'] . "</td>";
  
  echo "</tr>";
  }
echo "</table>";
 
mysql_close($con);
?>
</body>
</html>