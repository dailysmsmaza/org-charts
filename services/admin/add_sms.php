<?php

	$response = array();
	require("connect.php");
	include('Emoji.class.php');
	if(isset($_POST["username"]))
	{
					
		$status = $_POST["r"];
		$date = strtotime("now");
	
		$sms = $_POST["sms"];
		$sms = str_replace(array("\r\n", "\r", "\n"), "<br />", $sms); 
		$sms = trim(ucwords($sms));
		$sms = Emoji::emoji_to_html($sms);
		//$sms = str_replace(array("<div></div>"),"",$sms);
		//$sms = str_replace(array("<br>"),"<br/>",$sms);
		$sms = str_replace("'","''",$sms);			
		$sms = mysqli_real_escape_string($c,$sms);

		//$sms = htmlspecialchars($sms, ENT_NOQUOTES, "UTF-8");
		
		$cat_name = $_POST["cat_name"];
		
		$cat_name = mysqli_real_escape_string($c,$cat_name);
		
		$username =  $_POST["username"];
		$username = trim(ucwords($username));
		$username =  mysqli_real_escape_string($c,$username);
		
		$cat_name_exp = explode(",",$cat_name);
		$cat_count = count($cat_name_exp);
		
		
		for($i=0;$i<$cat_count - 1;$i++) 
		{
			$cat_name = $cat_name_exp[$i];
			$cat_name = trim(ucwords($cat_name));
			$category = mysqli_query($c,"select * from category where cat_name='$cat_name'") or die(mysqli_error());
			$category_count = mysqli_num_rows($category);
			if($category_count >= 1)
			{
				while($category_data = mysqli_fetch_array($category))
				{
					$cat_id[] = $category_data["cat_id"];
				}
			}
			else
			{
				$cat_insert = mysqli_query($c,"insert into category(cat_name,cat_title,status,p_id)values('$cat_name','$cat_name','Active','0')") or die(mysqli_error());
				if (mysqli_query($c,$cat_insert));
				{
					$last_cat_id = mysqli_insert_id($c);
					$cat_sub_insert = mysqli_query($c,"insert into category_sub
					(cat_id,cat_name,cat_order,p_id)values('$last_cat_id','$cat_name','$last_cat_id','0')") or die(mysqli_error()); 
				}
				$category = mysqli_query($c,"select * from category where cat_name='$cat_name'") or die(mysqli_error());
				while($category_data = mysqli_fetch_array($category))
				{
					$cat_id[] = $category_data['cat_id'];
				}
			
			}
		}		
		
		$user = mysqli_query($c,"select * from user where username='$username'") or die(mysqli_error());
		$user_count = mysqli_num_rows($user);
		if($user_count >= 1)
		{
		}
		else
		{	
				$user_insert = mysqli_query($c,"insert into user (username) values ('$username')") or die(mysqli_error());
		}
		
		$user_info = mysqli_query($c,"select * from user where username='$username'") or die(mysqli_error());
		
		while($user_data = mysqli_fetch_array($user_info))
		{
			$user_id = $user_data["user_id"];
			$user_name = $user_data["username"];
		}
	
		mysqli_query($c,"SET NAMES 'utf8'"); 
		mysqli_set_charset($c,"utf8");

		$msg_insert = mysqli_query($c,"insert into message(sms,date,status,user_id)values('$sms','$date','$status','$user_id')") or die(mysqli_error());
	
		$sms_id = mysqli_insert_id($c);
		
		foreach($cat_id as $sms_sub_cat_id)
		{
					
			$cat_sms = mysqli_query($c,"update category set all_sms = all_sms + 1 where cat_id='$sms_sub_cat_id'");						
			
			$sms_sub_insert = mysqli_query($c,"insert into message_sub
			(sms_id,cat_id)values('$sms_id','$sms_sub_cat_id')");
		}	

		$response["success"] = 1;
		$response["message"] = "Successfully Added";
			
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "No Data Found";
	}
?>