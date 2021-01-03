<?php

	include("connect.php");
	
	$response = array();
	
	if(isset($_GET["id"]))
	{
			$id = $_GET["id"];
		
			$category = mysqli_query($c,"SELECT * FROM category WHERE cat_id='".$id."'");
			
			if(mysqli_num_rows($category)>0)
			{	
				$response["data"] = array();
				
				while($category_data = mysqli_fetch_array($category))
				{	
					$data = array();
						
					$data["cat_id"] = $category_data["cat_id"];
					$data["cat_name"] = $category_data["cat_name"];
					$data["cat_desc"] = $category_data["cat_description"];
					
					array_push($response["data"],$data);
				}
				
				$response["success"] = 1;
			}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Error.! Missing Required Fields";
	}
	
	echo json_encode($response);

?>