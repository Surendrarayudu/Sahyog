<?php
 $insert = mysql_query("insert into $dbtableser values('95','Improved Database performance through migration to 64 bit','improveddatabaseperformance.ppt')"); 
 if (!$insert) 
		{
    		die ("Can\'t insert into $dbtableser : " . mysql_error()); // remove ?
		}
  ?>
  <a href="improveddatabaseperformance.ppt" style="text-decoration:none">