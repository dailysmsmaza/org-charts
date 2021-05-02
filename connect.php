<?php


if (CURRENT_MODE == PRODUCTION) {
	//LIVE DBF
	$c = mysqli_connect('localhost', 'hurvotmy_dsmadmin', 'xB@U&1g&T&AU', 'hurvotmy_dailysmsmaza') or die("Connection Error");
} else {
	//LOCAL DB
	$c = mysqli_connect('localhost','root','','dailysmsmaza') or die("Connection Error");

}
mysqli_query($c, "SET NAMES 'utf8mb4'"); 
	//mysqli_set_charset($c,"SET NAMES 'utf8mb4'");
