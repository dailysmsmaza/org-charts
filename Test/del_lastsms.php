<?php
	ob_end_flush();
	ob_start();
	session_start();
	require("connect.php");
	include("names.php");
	
if(isset($_SESSION["username"]))
{
	$id = $_GET["id"];
	$page = $_GET["page"];
	
	
	$msg = mysqli_query($c,"delete from message where id='$id'");
	
	$msg_sub_cat = mysqli_query($c,"select * from message_sub where sms_id='$id'");
	while($msg_sub_cat_data = mysqli_fetch_array($msg_sub_cat))
	{
			$msg_cat_id = $msg_sub_cat_data["cat_id"];
			
			$cat_sms = mysqli_query($c,"update category set all_sms = all_sms - 1 where cat_id='$msg_cat_id'");						
	}
	
	$msg_sub = mysqli_query($c,"delete from message_sub where sms_id=$id");
	
	header("location:$adminurl/last.php?page=$page");
}
else
{
	header("location:okes36569.php");
}
?>