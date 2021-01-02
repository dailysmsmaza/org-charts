<?php
	ob_end_flush();
	ob_start();
		
	include("names.php");
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

<?php include_once("analyticstracking.php"); ?>

	<div class="collapse navbar-collapse" id="myNavbar">
            	<ul class="nav navbar-nav navbar-right">
                	<li> <a href="<?=$url?>/signup/getinfo"><span class="glyphicon glyphicon-user"></span> Sign In </a> </li>
                    <li> <a href="<?=$url?>/login"><span class="glyphicon glyphicon-log-in"></span> Log In </a> </li>
                 </ul>
     </div>
</body>
</html>