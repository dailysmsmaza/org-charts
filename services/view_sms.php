<?php
	
	include("../createEmoji.php");
	include("connect.php");
	
	$response = array();

	if(isset($_GET["cat_id"]))
	{
		$cat_id = $_GET["cat_id"];
		
		$cat_id_data = mysqli_query($c,"select * from category where cat_id='".$cat_id."' ");
		$cat_id_data_count = mysqli_num_rows($cat_id_data);
		
		if($cat_id_data_count>0)
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
			
			$sub_message = mysqli_query($c,"select * from message_sub where cat_id='".$cat_id."' ORDER BY id DESC");	
			$sub_message_count = mysqli_num_rows($sub_message);
			
			if($sub_message_count>0)
			{
				$response["message_id"] = array();

				while($sub_message_data = mysqli_fetch_array($sub_message))
				{
					$data = array();
					
					$data["msg_id"] = $sub_message_data["sms_id"];
					
					array_push($response["message_id"],$data);
					
				}
				
				$response["success_sub"] = 1;
			}
			else
			{
				$response["success_sub"] = 0;
				$response["message"] = "No Sms Found";
			}
		}
		
	}
	
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		
		$response["message"] = array();
				
		$msg = mysqli_query($c,"select * from message where id='".$id."' AND status='Active'");

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
		$response["message"] = "Error.! Missing Fields.";
	}

	echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>