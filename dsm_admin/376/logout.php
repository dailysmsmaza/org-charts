<?php
	include("names.php");
	session_start();
	unset($_SESSION["username"]);
	header("location:".$url);
?>