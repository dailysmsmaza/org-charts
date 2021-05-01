<?php
	
	//LOCAL DB
	// $c = mysqli_connect('localhost','root','','dailysmsmaza') or die("Connection Error");
	
	//LIVE DB
	$c = mysqli_connect('localhost','hurvotmy_dsmadmin','xB@U&1g&T&AU','hurvotmy_dailysmsmaza') or die("Connection Error");
	
	mysqli_query($c,"SET NAMES 'utf8mb4'"); 
	//mysqli_set_charset($c,"SET NAMES 'utf8mb4'");
	
?>