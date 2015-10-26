<?php
$con=mysql_connect("localhost","root","sahyog");
$select=mysql_select_db("serengne");
//error_reporting(0);
if(isset($_GET['id']))
{
$id=$_GET['id'];
//echo $id;
$del=mysql_query("delete from edit where id='$id'");
if(!$del)
{
echo "errr".mysql_error();
}	//header("location:index.php");

}
echo $id." deleted successfully";

?>
