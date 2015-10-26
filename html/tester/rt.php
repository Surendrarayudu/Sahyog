<html>
<head>
<title>Update a Record in MySQL Database</title>
</head>
<body>

<?php
if(isset($_POST['update']))
{
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'sahyog';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE rt ".
       "SET name= $name ".
       "WHERE id = $id" ;

mysql_select_db('serengne');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not update data: ' . mysql_error());
}
echo "Updated data successfully\n";
mysql_close($conn);
}
else
{
?>
<form method="post" action="<?php $_PHP_SELF ?>">
<table width="400" border="0" cellspacing="1" cellpadding="2">
<tr>
<td width="100"> id</td>
<td><input name="id" type="text" id="id"></td>
</tr>
<tr>
<td width="100">name</td>
<td><input name="name" type="text" id="name"></td>
</tr>
<tr>
<td width="100"> </td>
<td> </td>
</tr>
<tr>
<td width="100"> </td>
<td>
<input name="update" type="submit" id="update" value="Update">
</td>
</tr>
</table>
</form>
<?php
}
?>
</body>
</html>
