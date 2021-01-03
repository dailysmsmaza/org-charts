<?php
	
	include('../createEmoji.php');
	require_once("connect.php");

	$response[] = array();
	
	if(isset($_GET["page"]))
	{
		$page = $_GET["page"];
	
		$limit = 10;
		$start = ($page-1) * $limit;
		
		$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by id desc");
		$pages_row = mysqli_fetch_row($pages_query);
		$total_records = $pages_row[0];
					
		if($total_records > 0)
		{
			$response["total_records"] = $total_records;
		
			$response["message"] = array();
			
			$msg = mysqli_query($c,"select * from message where status='Active' order by id desc LIMIT $start, $limit");
			
			while($msg_data = mysqli_fetch_array($msg))
			{
				$data = array();
				
				$data["msg_id"] = $msg_data["id"];
				$data["msg_sms"] = $client->shortnameToUnicode($msg_data["sms"]);

				array_push($response["message"],$data);
			}
			
			$response["success"] = 1;
		}
		else
		{
			$response["success"] = 0;
			$response["message"] = "No SMS Found";
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Something Wrong.!";
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>