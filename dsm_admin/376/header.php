<?php
	ob_end_flush();
	ob_start();
	include("names.php");
?>
<!doctype html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">

<title> <?=$title?> Admin Panel</title>
</head>

<body>

<div class="top">
		<div class="logo">
			<div class="left"> <?=$title?> Admin Panel </div>
		</div>

 <div class="end">
	<ul id="qm0" class="qmmc">
		<li><a class="qmparent" href="<?=$adminurl?>/home.php?id=0&limit=all">Home</a> </li> 	
		<li><a class="qmparent" href="default_menu.php"> Default Menu </a></li>
        <li><a class="qmparent" href="user_messages.php"> User Message </a></li>
        <li><a class="qmparent" href="Advertise.php"> Advertisement </a></li>
		<li><a class="qmparent">Admin</a>
	  		<ul>
				<li><a href="<?=$adminurl?>/adminchange.php">Edit Admin Profie</a></li>
        		<li><a class="qmparent" href="<?=$adminurl?>/logout.php">Logout</a></li>
	  		</ul>
		</li>
	</ul>
</div>

</div>

</body>
</html>


