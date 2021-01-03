<?php

	include('../createEmoji.php');
	include("connect.php");
	
	$response[] = array();
	
	$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by likes");
	$pages_row = mysqli_fetch_row($pages_query);
	$total_records = $pages_row[0];
	
	if($total_records>0)
	{
		$response["total_records"] = $total_records;
		
		$response["message"] = array();
		
		$msg = mysqli_query($c,"select * from message where status='Active' order by likes desc LIMIT 0,10");
					
		while($msg_data = mysqli_fetch_array($msg))
		{
			$data = array();
			
			$data["msg_id"] = $msg_data["id"];
			$data["msg_sms"] = $client->shortnameToUnicode($msg_data["sms"]);
			
			array_push($response["message"],$data);
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "No SMS Found";
	}
	
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
						