<?php
	ob_end_flush();
	ob_start();
	session_start(); 
	include("names.php");
	include("my_function.php");

if(isset($_SESSION["username"]))
{
	require("connect.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
	
	$id = $_GET["id"];
	
	$delete_msg = mysqli_query($c,"delete from user_message where id='$id'");
	mysqli_close($c);
	
	header("location:$adminurl/user_messages.php");			
    
}
	
else
{
	header("location:$adminurl/home.php?id=0");
}

?>