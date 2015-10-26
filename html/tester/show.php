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
 
$result = mysql_query("SELECT * FROM ipadrss order by 1");
 
echo "<table border='1'>
<tr>
<th>Id</th>
<th>CenterName</th>
<th>IPAddress</th>
<th>UserName</th>
<th>DeptName</th>
<th>Status</th>
<th>MachineName</th>
<th>Access</th>
<th>Operation</th>
</tr>";
 
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['centername'] . "</td>";
  echo "<td>" . $row['ipadress'] . "</td>";
  echo "<td>" . $row['username'] . "</td>";
   echo "<td>" . $row['dept'] . "</td>";
   echo "<td>" . $row['status'] . "</td>";
   echo "<td>" . $row['machinename'] . "</td>";
   echo "<td>" . $row['Access'] . "</td>";
   echo "<td>" . $row['operation'] . "</td>";
  
  echo "</tr>";
  }
echo "</table>";
 
mysql_close($con);
?>
</body>
</html>