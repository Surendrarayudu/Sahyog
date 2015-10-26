<body bgcolor="#CCFFCC">
<!--<link rel="stylesheet" href="style1.css" type="text/css" media="all">-->
<?php
session_start();
//include('/style1.css');
if($_SESSION['user']!="")
{
	$con=mysql_connect("localhost","root","sahyog");
	$select=mysql_select_db("serengne");

error_reporting(0);
?>
<div id ='search'>
<table height="80" width="1000" align="center">
<tr>
<td><font size="+3"color="#990033"><?php echo "Welcome  ".$_SESSION['user'];?></font></td>
<td><font size="+2" color="#990033"><a style="float:right;" href="logout.php">LOGOUT</a></font></td></tr>
<tr><td><div align="right" bordercolor="#0000FF"><form action="search.php" method="post"  >
<input type="text" name="search_name" size="60" maxlength="40" >
<input type="submit" value="Quick Search">
</form></td></tr></div>

<br>
<tr><td align="left"><span><a style="left" href="show.php"><font size="+2" color="#990033">List Of IP Address</font></a></span></td></tr>
<tr><td align="left"><span><a style="left" href="acs.php"><font size="+2" color="#990033">Account Settings</font></a></span></td></tr>
</tr></table>
<select name="ud_Borrwd_Rsn">
    <option><?php echo $row['ud_Borrwd_Rsn']; ?></option>
    <option>Borrowed</option>
    <option>Repair</option>
    <option>Replacement</option>
    <option>Other</option>
</select>

<?php
}
 else
{
header("location:index.php");
}