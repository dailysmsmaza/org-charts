<?php

			include("connect.php");
			
			$searchTerm = $_GET["term"];
			
			$result = array();
			
			//$category_list = mysqli_query($c,"select DISTINCT c.cat_name from category c INNER JOIN message_sub m INNER JOIN category_sub s where m.cat_id=c.cat_id AND c.cat_name LIKE '%".$searchTerm."%' ");
			$category_list = mysqli_query($c,"select cat_name from category where cat_name LIKE '%".$searchTerm."%' ");
			
			while($category_list_data = mysqli_fetch_array($category_list))
			{
					$data[] = $category_list_data['cat_name'];
			}
			
			echo json_encode($data);
			
			
?>