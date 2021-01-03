<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
	require("connect.php");
	
if(isset($_SESSION['username']))
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$pid = $_GET["pid"];
		
		function delete_all_sms($id)
		{
			global $c;
			global $adminurl;
			
			$pid = $_GET["pid"];
			
			$category = mysqli_query($c,"select * from category_sub where p_id='$id'");
			$category_count = mysqli_num_rows($category);
			
			$sms_sub = mysqli_query($c,"select * from message_sub where cat_id='$id'");
			$sms_sub_count = mysqli_num_rows($sms_sub);
			
			if($category_count>=1)
			{
				while($category_data = mysqli_fetch_array($category))
				{
					$category_id = $category_data["cat_id"];
					$category_id_all[] = $category_id;
					
					$category_id_chk = mysqli_query($c,"select count(p_id) from category_sub where p_id=$id");
					$category_id_chk_count = mysqli_num_rows($category_id_chk);
					
					for($i=1;$i<=$category_id_chk_count;$i++)
					{
						delcat($category_id);
					}
				}
				if(!empty($category_id_all))
				{	
					foreach($category_id_all as $all_category_id)
					{
						$msg_sub = mysqli_query($c,"select * from message_sub where cat_id='$all_category_id'");
						while($msg_sub_data = mysqli_fetch_array($msg_sub))
						{
							$msg_sub_msg_id = $msg_sub_data["sms_id"];	
							$msg_delete = mysqli_query($c,"delete from message where id='$msg_sub_msg_id'");
						}
						$msg_sub_delete = mysqli_query($c,"delete from message_sub where cat_id='$all_category_id'");
						
						$update_category = mysqli_query($c,"update category set all_sms='0' where cat_id='$id'");
					}  
				}
			}
			if($sms_sub_count>=1)
			{
				while($sms_sub_data = mysqli_fetch_array($sms_sub))
				{	
					$sms_delete = mysqli_query($c,"delete from message where id='$sms_sub_sms_id'");
				}
				$msg_sub_delete = mysqli_query($c,"delete from message_sub where cat_id='$id'");
			}
			
			$update_category = mysqli_query($c,"update category set all_sms='0' where cat_id='$id'");
			
			header("location:$adminurl/home.php?id=$pid");
			
		}
		
		delete_all_sms($id);
						
	}
	else
	{
		echo "Sorry Id Not Found";
	}
}

				

?>
	