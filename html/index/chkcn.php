<!DOCTYPE html>
<html lang="en">
<head>
<style type="text/css">
body {margin: 0;padding: 0;}
.wrap {height: 1000px;width: 1000px;margin: 0 auto;position: relative;}
.head {height: 100px;width: 1000px;margin: 0 auto;position: relative;background:#CCC;}
.content {height: 600px;width:1000px;margin:0 auto;position:relative;background:#999;}
.footer {height:100px;width:800px;margin: 0 auto;position:relative;background:#333;}
</style> 

<title>SAHYOG | REPORTS</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-replace.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_300.font.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<!--[if lt IE 7]>
<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen">
<script type="text/javascript" src="js/ie_png.js"></script>
<script type="text/javascript">ie_png.fix('.png, footer, header nav ul li a, .nav-bg, .list li img');</script>
<![endif]-->
<!--[if lt IE 9]><script type="text/javascript" src="js/html5.js"></script><![endif]-->
</head>
<body id="page3">
<!-- START PAGE SOURCE -->
<div class="wrap">
  <header>
    <div class="container">
      <h1><a href="#">AMARUJALA SAHYOG</a></h1>
      <nav>
        <ul>
          <li><a href="index.php" class="m1">Home Page</a></li>
          <li><a href="itstructure.html" class="m2">IT STRUCTURE</a></li>
          <li class="current"><a href="reports.html" class="m3">REPORTS</a></li>
          <li><a href="itpolicies.html" class="m4">IT POLICIES</a></li>
          <li class="last"><a href="knowledgebase.html" class="m5">KNOWLEDGE BASE</a></li>
        </ul>            
  <marquee direction="" scrollamount="2" onmouseover="this.stop();"onmouseout="this.start();";style="height:200px;"><h4><font color="black"><li><a   href="patch1.html"target="_blank"><font color="black">SECURE YOUR SYSTEM WITH UPDATED ANTIVIRUS<h4></marquee>

   <p><br><div align="right"><form action="search1.php" method="post">
<fieldset>
          <div class="rowElem">

<input type="text" name="search_name">
<input type="submit" value="search"> </div>
        </fieldset>
</p>
      </form>
    </div>
  </header>
    <div class="container">
     <aside><p><h3></h3></p><section id="content"><p><ul class="categories"></P> 
     </ul>
	 <?php
	 include("connect.php"); 
	 while($row = $result->fetch_array())?>
     <?php { ?>
 	<a  href="<?php echo $row['pgurl'];?>?<?php echo $row['1'];?>"><?php echo "ritika";//$row['pgcontent'];?></a>
  } 
  <?php }?>
  
  

