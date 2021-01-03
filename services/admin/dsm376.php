<?php
	
	$response = array();
	
	require("connect.php");
	
	if(isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
			
		if(!empty($username) && !empty($password))
		{
			$q = mysqli_query($c,"select * from admin where username='".$username."' AND password='".$password."'");
			if(mysqli_num_rows($q)>0)
			{
				$response["success"] = 1;
				$response["message"] = "You Are Authorized";
			}
			else
			{
				$response["success"] = 0;
				$response["message"] = "You Are Not Authorized";
			}
		}
		else
		{
			$response["success"] = 0;
			$response["message"] = "Field Is Empty";
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Field Is Required";
	}
	
	echo json_encode($response);
?>