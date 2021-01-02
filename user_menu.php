<?php
	ob_end_flush();
	ob_start();
	include("names.php");
	
	$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
  <script src="bootstrap/jquery.min.js"></script>
  <script src="bootstrap/bootstrap.min.js"></script>
  
</head>
<body>
	<div class="collapse navbar-collapse" id="myNavbar">
            	<ul class="nav navbar-nav navbar-right">
                	<li> <a href="<?=$url?>/account/info"> <span class="glyphicon glyphicon-user"></span> <?php //echo $username; ?> </a> </li>
                    <li> <a href="<?=$url?>/addsms/noconfirm"> <span class="glyphicon glyphicon-envelope"></span> Add Sms </a> </li>
                    <li> <a href="<?=$url?>/mysms/page/1"> <span class="glyphicon glyphicon-file"></span> My Sms </a> </li>
                    <li> <a href="<?=$url?>/logout"> <span class="glyphicon glyphicon-off"></span> Logout </a> </li>
                 </ul>
     </div>
</body>
</html>


