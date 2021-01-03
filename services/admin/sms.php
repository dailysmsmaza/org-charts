<?php
	
	include("../createEmoji.php");
	include("connect.php");
	
	$response =array();

	if(isset($_GET["id"]))
	{
		if(isset($_GET["page"]))
		{
			$page = $_GET["page"];
		}
		else
		{
			$page = 1;
		}
		
		$id = $_GET["id"];
		
		$limit = 20;
		$start = ($page-1) * $limit;
		
		$cat_id = mysqli_query($c,"select * from category where cat_id=$id");
		$cat_id_count = mysqli_num_rows($cat_id);

		if($cat_id_count>0)
		{
			$response["category"] = array();

			while($cat_id_data = mysqli_fetch_array($cat_id))
			{
				$data = array();

				$data["cat_id"] = $cat_id_data["cat_id"];
				$data["cat_name"] = $cat_id_data["cat_name"];

				array_push($response["category"],$data);
				//$cat_id_rename  = str_replace(array(" ","(",")"),array(""),$cat_id_name);
			}
			
			$pages_query = mysqli_query($c,"select count(id) from message_sub where cat_id='$id' order by id desc");
			$pages_row = mysqli_fetch_row($pages_query);
			$total_records = $pages_row[0];

			$response["total_records"] = $total_records;
			
			$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$id' ORDER BY id DESC LIMIT $start, $limit");	
			$sub_message_count = mysqli_num_rows($sub_message);
			
		
			
			if($sub_message_count>0)
			{
				$response["message"] = array();

				while($sub_message_data = mysqli_fetch_array($sub_message))
				{
					$sub_message_sms_id = $sub_message_data["sms_id"];
					
					$msg = mysqli_query($c,"select * from message where id='".$sub_message_sms_id."' AND status='Active'");

					while($msg_data = mysqli_fetch_array($msg))
					{
						$data = array();
						
						$data["msg_id"] = $msg_data["id"];
						$data["msg_sms"] = $client->shortnameToUnicode($msg_data["sms"]);

						array_push($response["message"],$data);
					}
				}
				$response["success_sub"] = 1;
			}
			else
			{
				$response["success_sub"] = 0;
				$response["message"] = "No Sms Found";
			}
			$response["success"] = 1;
		}
		else
		{
			$response["success"] = 0;
			$response["message"] = "No Category Found.";
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Error.! Missing Fields.";
	}

	echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>