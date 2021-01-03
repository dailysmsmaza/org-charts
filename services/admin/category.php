<?php

	$response = array();
	
	include("connect.php");
	
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		
		$category = mysqli_query($c,"SELECT * FROM category WHERE cat_id='".$id."'");
		
		if(mysqli_num_rows($category)>0)
		{
			$response["category"] = array();
			
			while($row = mysqli_fetch_array($category))
			{
				$data = array();
				
				$data["cat_id"] = $row["cat_id"];
				$data["cat_name"] = $row["cat_name"];
				
				array_push($response["category"],$data);
			}
			
			$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id='".$id."' order by cat_order");
			
 			if(mysqli_num_rows($category_sub_data_limit)>0)
			{
				$response["category_sub"] = array();
				
				while($category_sub_data=mysqli_fetch_array($category_sub_data_limit))
				{
					$category_sub_cat_id = $category_sub_data["cat_id"];
					
					$category_sub = mysqli_query($c,"select * from category where cat_id='".$category_sub_cat_id."' ");
					
					while($category_data = mysqli_fetch_array($category_sub))
					{			
						$sub_data = array();
						
						$sub_data["cat_id"] = $category_data["cat_id"];
						$sub_data["cat_name"] = $category_data["cat_name"];
					
						array_push($response["category_sub"],$sub_data);
					}
				}
				$response["success_sub"] = 1;
			}
			else
			{
				$response["success_sub"] = 0;
				$response["message"] = "No Sub Category Found";
			}
			$response["success"] = 1;
		}
		else
		{
			$response["success"] = 0;
			$response["message"] = "No Data Found.";
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Error.! Missing Fields.";
	}
	
	echo json_encode($response);
	
?>