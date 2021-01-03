<?php

	include("connect.php");
	include('../createEmoji.php');

	$response[] = array();

	$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by likes");
	$pages_row = mysqli_fetch_row($pages_query);
	$total_records = $pages_row[0];

	if($total_records > 0)
	{						

		$response["total_records"] = $total_records;

		$response["data"] = array();

		$msg = mysqli_query($c,"select * from message where status='Active' order by likes desc LIMIT 1,20");	
		while($msg_data = mysqli_fetch_array($msg))
		{
			$data = array();

			$data["msg_id"] = $msg_data["id"];
			$data["msg_sms"] = $client->shortnameToUnicode($msg_data["sms"]);

			array_push($response["data"], $data);
		}

		$response["success"] = 1;
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "No Latest SMS Found.";
	}

	echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>