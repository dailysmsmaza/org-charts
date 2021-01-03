<?php
	include("connect.php");

	$response =array();

	$user = mysqli_query($c,"SELECT * FROM user ORDER BY RAND()");
	$user_count = mysqli_num_rows($user);

	if($user_count>0)
	{
		$response["username"] = array();

		while($user_data = mysqli_fetch_array($user))
		{			
			$data = array();

			$data["user_name"] = $user_data["username"];

			array_push($response["username"],$data);
		}

		$response["success"] = 1;
	}
	else
	{
		$response["success"] = 0;	
		$response["message"] = "No Username Found.";
	}

	echo json_encode($response);
?>