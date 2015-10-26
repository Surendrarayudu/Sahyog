<?php
//include ('connect.php');
$servername = "localhost";
$username = "root";
$password = "sahyog";
$dbname = "serengne";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if(isset($_POST ['search_name']))
{
 $search_name=$_POST['search_name'];

if(!empty ($search_name))
{
	$sql="SELECT * FROM ipadrss WHERE concat(ipadress,centername,username,dept) LIKE '%$search_name%'";

	$result= $conn->query($sql);

if($result ->num_rows == 0)
{  echo "\n"."<br><br>"."\n"."<br><br>";

echo "<b>".'SORRY NO RECORDS WERE NOT FOUND'."</b>";	
}
else
{
echo "<table  style='border:dashed' border='2' align='left' height='100' width='1000'>
<tr>
<th>Id</th>
<th>CenterName</th>
<th>IPAdress</th>
<th>Username</th>
<th>Departname</th>
<th>status</th>
<th>MachineName</th>
<th>Access</th>
<th>Operation</th>
</tr>";
echo "\n"."\n";  
echo "<tr>";
 //echo "<br><br>"."<b>".'RECORDS WERE FOUND'."</b>"."<br>";
  while($row = $result->fetch_array())
	{

  	echo "<td>" . $row['id'] .      "</td>";
  	echo "<td>" . $row['centername'] .  "</td>";
  	echo "<td>" . $row['ipadress'] .  "</td>";
  	echo "<td>" . $row['username'] .  "</td>";
   	echo "<td>" . $row['dept'] .  "</td>";
   	echo "<td>" . $row['status'] .  "</td>";
   	echo "<td>" . $row['machinename'] . "</td>";
   	echo "<td>" . $row['Access'] .  "</td>";
   	echo "<td>" . $row['operation'] . "</td>";
  	echo "</tr>";
  }
echo "</table>";
	//echo "<br><br>"."<b>". $row['ipadress'].$row['username']. $row['dept']."</b>";
	
	}
}
	}

?>