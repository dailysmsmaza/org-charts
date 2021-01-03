<?php
    
    include_once('connect.php');
	include("names.php");
	
    if(isset($_POST['bulk_delete_submit']))
	{
        $idArr = $_POST['checked_id'];
		
		if(isset($_POST["page_no"]) && isset($_POST["cat_id_hide"]) )
		{
			$page_no = $_POST["page_no"];
			$cat_id = $_POST["cat_id_hide"];

			foreach($idArr as $id)
			{
				$msg = mysqli_query($c,"delete from message where id='$id'");
	
				$msg_sub_cat = mysqli_query($c,"select * from message_sub where sms_id='$id'");
				while($msg_sub_cat_data = mysqli_fetch_array($msg_sub_cat))
				{
						$msg_cat_id = $msg_sub_cat_data["cat_id"];
						
						$cat_sms = mysqli_query($c,"update category set all_sms = all_sms - 1 where cat_id='$msg_cat_id'");						
				}
				
				$msg_sub = mysqli_query($c,"delete from message_sub where sms_id=$id");
			}	
			
			header("location:$adminurl/home.php?id=$cat_id");
		}
		
    }
?>