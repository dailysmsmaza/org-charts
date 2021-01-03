<?php

	require("connect.php");

	$response = array();

	$cat = mysqli_query($c,"SELECT * FROM category WHERE cat_id IN (SELECT cat_id FROM message_sub) ");
	$cat_count = mysqli_num_rows($cat);

	if($cat_count > 0)
	{
		$response["category"] = array();

		while($cat_data = mysqli_fetch_array($cat))
		{
			$data = array();
			$data["cat_name"] = $cat_data["cat_name"];
			array_push($response["category"], $data);
		}
		$response["success"] = 1;
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "No Category Found";
	}

	echo json_encode($response);

?>