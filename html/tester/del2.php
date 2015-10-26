
<html>
<head>
<title>Delete a Record from MySQL Database</title>
</head>
<body>

<?php
if(isset($_POST['delete']))
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

$sql = "DELETE edit ".
       "WHERE id = $id" ;

mysql_select_db('serengne');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";
mysql_close($conn);
}
else
{
?>
<form method="post" action="<?php $_PHP_SELF ?>">
<table width="400" border="0" cellspacing="1" cellpadding="2">
<tr>
<td width="100"> ID</td>
<td><input name="id" type="text" id="id"></td>
</tr>
<tr>
<td width="100"> </td>
<td>
</tr>
<tr>
<td width="100"> </td>
<td>
<input name="delete" type="submit" id="delete" value="Delete">
</td>
</tr>
</table>
</form>
<?php
}
?>
</body>
</html>