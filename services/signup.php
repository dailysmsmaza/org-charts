<?php	
	include("connect.php");
	
	$response[] = array();

	if(isset($_POST["display_name"]) && isset($_POST["email"]) || isset($_POST["phone"]) && isset($_POST["password"]))
	{
		$display_name = $_POST["display_name"];
		
		if(isset($_POST["email"]))
		{
			$email = $_POST["email"];
		}
		if(isset($_POST["phone"]))
		{
			$phone = $_POST["phone"];
		}
	
		$password = $_POST["password"];
		
		if(!empty($email))
		{
			$check_email = mysqli_query($c,"SELECT * FROM user WHERE email='".$email."'");
		}
		if(!empty($phone))
		{
			$check_phone = mysqli_query($c,"SELECT * FROM user WHEREm phone='".$phone."' ");
		}
				
		if(mysqli_num_rows($check_email)>0 OR mysqli_num_rows($check_phone)>0)
		{
			$response["success"] = 0;
			$response["message"] = "Email or Phone Already Exists";
		}		
		else
		{
			if(!empty($email))
			{
				$user = mysqli_query($c,"INSERT INTO user (display_name, email, password) values ('".$display_name."','".$email."','".$password."')");	
			}
			if(!empty($phone))
			{
				$user = mysqli_query($c,"INSERT INTO user (display_name, phone, password) values ('".$display_name."','".$phone."','".$password."')");	
			}
			
			$user_id = mysqli_insert_id($c);
			
			$response["success"] = 1;
			$response["user_id"] = $user_id;
		}	
	}
	
	echo json_encode($response);
?>