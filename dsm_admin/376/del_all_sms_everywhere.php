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
		set_time_limit(0);
		
		$id = $_GET["id"];
		$pid = $_GET["pid"];
		
		function delete_all_sms($id)
		{
			global $c;
			global $adminurl;
			
			$pid = $_GET["pid"];
			
			$sms_sub = mysqli_query($c,"select * from message_sub where cat_id='$id'");
			$sms_sub_count = mysqli_num_rows($sms_sub);
			
			 if($sms_sub_count>=1)
			 {
			 	while($sms_sub_data = mysqli_fetch_array($sms_sub))
			 	{	
					$msg_sub_msg_id = $sms_sub_data["sms_id"];

					$sms_sub_sub = mysqli_query($c,"select * from message_sub where sms_id='$msg_sub_msg_id'");
					$sms_sub_sub_count = mysqli_num_rows($sms_sub_sub);

					if($sms_sub_sub_count>=1)
					{
						while($sms_sub_sub_data = mysqli_fetch_array($sms_sub_sub))
						{	 
							$sms_sub_sub_data_cat_id = $sms_sub_sub_data["cat_id"];

							 $update_category = mysqli_query($c,"update category set all_sms=all_sms-1 where cat_id='$sms_sub_sub_data_cat_id'");
						}
					}
					$sms_delete = mysqli_query($c,"delete from message where id='$msg_sub_msg_id'");
					$msg_sub_delete = mysqli_query($c,"delete from message_sub where sms_id='$msg_sub_msg_id'");
			 	}
			 }
			
			 
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
	