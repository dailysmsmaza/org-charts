<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");						
	unset($_SESSION[$s_name]);
	header("location:$url/");
?>