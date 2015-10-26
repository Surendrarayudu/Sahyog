<?php
include("bkpage.php");
include ("connect.php");

if(isset($_POST['search_name']))
{
 $search_name=$_POST['search_name'];

if(!empty ($search_name))
{
	$sql="SELECT * FROM ser WHERE pgcontent LIKE '%$search_name%' LIMIT 0, 10";

	$result= $conn->query($sql);

if($result ->num_rows == 0)
{  echo "\n"."<br><br>"."\n"."<br><br>";
	
echo "<b>"."<font size=+2 color=#FF0000>".'NO MATCH WERE FOUND'."</font>"."</b>";	
}
else
{
 echo "<br><br>"."<b>"."<font size=+2 color=#FF0000>".'MATCH FOUND'. '%$search_name%'."</font>"."</b>"."<br>";
  while($row = $result->fetch_array())
	{  echo "\n"."\n"; 

     echo $row['pgurl'];
	 echo "<br><br>"."<b>"."<font size=+1>".$row['pgcontent']."</font>"."</b>";

	}
}
	}
}
?>


