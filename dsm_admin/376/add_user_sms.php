<?php

// This File Is Called When Correct Button Is Clicked !

	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
	
	if(isset($_SESSION["username"]))
	{
		include("header.php");
		require("connect.php");
		include("my_function.php");
		
		$id = $_GET["id"];

		$user_message = mysqli_query($c,"select * from user_message where id='$id'");
		while($user_message_data=mysqli_fetch_array($user_message))
		{
			$user_message_id = $user_message_data["id"];
			$user_message_sms = $user_message_data["sms"];
			$user_message_cat_id = $user_message_data["cat_id"];			
			$user_message_user_id = $user_message_data["user_id"];
			$user_message_date = $user_message_data["date"];

		}
		
		$message = mysqli_query($c,"insert into message (sms,date,status,user_id) values ('$user_message_sms','$user_message_date','Active','$user_message_user_id') ");
		
		$last_sms_id = mysqli_insert_id($c);
		
		$cat_msg_count = mysqli_query($c,"UPDATE category SET all_sms = all_sms + 1 WHERE cat_id='$user_message_cat_id'");
		
		$message_sub = mysqli_query($c,"insert into message_sub (sms_id,cat_id) values ('$last_sms_id','$user_message_cat_id') ");
		
		$user_message_delete = mysqli_query($c,"delete from user_message where id='$user_message_id'");
	
		mysqli_close($c);
		
		header("location:user_messages.php");
	}
	else
	{
		header("location:$url");
	}
?>
