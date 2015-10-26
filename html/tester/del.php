<?php
$con=mysql_connect("localhost","root","sahyog");
$select=mysql_select_db("serengne");
error_reporting(0);
echo"connect";

$id=$_GET['id'];
//$uname=$_GET['uname'];
$del=mysql_query("delete from edit where id='$id'");
if($del)
{
	header("location:del.php");
}
else
{
	echo "errr".mysql_error();
}

?>
<?php /*?>/*<?php
$con=mysql_connect("localhost","root","sahyog");
$select=mysql_select_db("serengne");
error_reporting(0);
$id=$_GET['id'];
//$f_id=$_GET['f_id'];
$del=mysql_query("delete from ipadrss where id='$id'");
echo "deletd";
header("location:home.php");
?>*/
 /*?>if(isset($_POST['id']))
{
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'sahyog';
$con = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $con )
{
  die('Could not connect: ' . mysql_error());
}
//echo "conected";
$id = $_GET['id'];

$sql = "DELETE ipadrss WHERE id = $id" ;

mysql_select_db('serengne');
$retval = mysql_query( $sql, $con);
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
echo "Deleted data successfully\n";
include("show.php");
mysql_close($con);
}*/

