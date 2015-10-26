<?php
include("wel.php");
include("nav.php");
ob_start();
$id=$_GET['id'];
?>
<table>
<tr><td></td></tr></table>
</td></tr></table>
<form action="" method="post">>
<table align="center" background="" border="5" style=" border:thin" height="100" width="100" >
<tr><td>Center Name: <input type="text" name="cname" /><br></td></tr>
<tr><td>IpAdresss: <input type="text" name="ipadrs" /><br></td></tr>
<tr><td>UserName: <input type="text" name="uname" /><br></td></tr>
<tr><td>Department: <input type="text" name="dpname" /><br></td></tr>
<tr><td>Status: <input type="text" name="stats" /><br></td></tr>
<tr><td>Machine Name: <input type="text" name="mname" /><br></td></tr>
<tr><td>Access: <input type="text" name="Access" /><br></td></tr>
<tr><td>Operation: <input type="text" name="Operation" /><br></td></tr>
<tr><td><input type="submit" name="update" value="edit"></td></tr>
</table>
</form>
<?php
if(isset($_POST['edit']))
	{
	$c=$_POST['cname'];
	$i=$_POST['ipadrs'];
	$u=$_POST['uname'];
	$d=$_POST['dpname'];
	$s=$_POST['stats'];
	$m=$_POST['mname'];
	$ac=$_POST['Access'];
	$sel=mysql_query("select * from ipadrss");	
	
	//$name=$_FILES['file']['name'];
	//$temp_name=$name.date('dsmi');
	
$edit=mysql_query("update ipadrss SET centername='$c',
ipadress='$i',username='$u',dept='$d',status='$s',machinename='$m',Access='$ac' where id = $id'");
	if($edit)
	{
$sel=mysql_query("select * from ipadrss where id='$id'");
$r=mysql_fetch_array($sel)
?>
<?php
header("location:show.php?id=$t");
		}
	else
	{
		echo "error".mysql_error();
	}
	}
	?>
<table  style="border:thick" border="5" align="center" height="100" width="1000" cellpadding="7" cellspacing="5">
<th>Id</th>
<th>cname</th>
<th>ipadress</th>
<th>uname</th>
<th>dpname</th>
<th>status</th>
<th>mname</th>
<th>Access</th>
</tr>";
</tr>
<?php
$sel=mysql_query("select * from ipadrss where id='$id'");
while($r=mysql_fetch_array($sel))
{
?>
<tr>
<td><?php echo $r['0'];?></td>
<td><?php echo $r['1'];?></td>
<td><?php echo $r['2'];?></td>
<td><?php echo $r['3'];?></td>
<td><?php echo $r['4'];?></td>
<td><?php echo $r['5'];?></td>
<td><?php echo $r['6'];?></td>
<td><?php echo $r['7'];?></td>

</tr>
<?php 
}
?>
</table>
