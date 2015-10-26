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
<tr><td>Name: <input type="text" name="name" /><br></td></tr>

<tr><td><input type="submit" name="update" value="edit"></td></tr>
</table>
</form>
<?php
if(isset($_POST['edit']))
	{
	$c=$_POST['name'];
		
	$name=$_FILES['file']['name'];
	$temp_name=$name.date('dsmi');
	//$move=move_uploaded_file($_FILES['file']['tmp_name'],"cat/$temp_name");
	//$sel=mysql_query("select * from edit");	
	$edit=mysql_query("update edit SET name='$c' where id = $id'");
	if($edit)
	{
	$sel=mysql_query("select * from  edit where id='$id'");
	$r=mysql_fetch_array($sel)
?>
<?php
header("location:sh.php?id=$id");
		}
	else
	{
		echo "error".mysql_error();
	}
	}
	?>
<table  style="border:thick" border="5" align="center" height="100" width="1000" cellpadding="7" cellspacing="5">
<th>Id</th>
<th>name</th>

</tr>";
</tr>
<?php
$sel=mysql_query("select * from  edit where id='$id'");
while($r=mysql_fetch_array($sel))
{
?>
<tr>
<td><?php echo $r['0'];?></td>
<td><?php echo $r['1'];?></td>

</tr>
<?php 
}
?>
</table>
