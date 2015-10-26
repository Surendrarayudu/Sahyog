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
 
$result = mysql_query("SELECT * FROM edit order by 1");
 
echo "<table border='1'>
<tr>
<th>Id</th>
<th>Name</th>
<th>Operation</th>
</tr>";
 
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['operation'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
 
mysql_close($con);
?>
</body>
</html>