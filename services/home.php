<?php

	include("connect.php");
	
	$response = array();
	
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		
		$category_sub = mysqli_query($c,"select * from category_sub where p_id='".$id."' order by cat_id");
		$category_sub_count = mysqli_num_rows($category_sub);
		
		if($category_sub_count>=1)
		{
			$response["data"] = array();
				
			while($category_sub_data=mysqli_fetch_array($category_sub))
			{
				$category_sub_cat_id = $category_sub_data["cat_id"];
				
				$category = mysqli_query($c,"select * from category where cat_id='".$category_sub_cat_id."' ");
				
				while($category_data = mysqli_fetch_array($category))
				{
					$data = array();
					
					$data["cat_id"] = $category_data["cat_id"];
					$data["cat_name"] = $category_data["cat_name"];
					//$data["category_title"] = $category_data["cat_title"];
					//$data["category_description"] = $category_data["cat_description"];
					//$data["category_status"] = $category_data["status"];
					
					array_push($response["data"],$data);
				}
			}

			$response["success"] = 200;
			$response["message"] = "Ok";
		}
		else
		{
			$response["success"] = 204;
			$response["message"] = "No Content Found";
		}
	}
	else
	{
		$response["success"] = 401;
		$response["message"] = "Un Authorized";
	}
	

	echo json_encode($response);
	
?>