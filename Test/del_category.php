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
		
		function delcat($id)
		{
			global $c;
			global $adminurl;
			
			$pid = $_GET["pid"];
			
			$category = mysqli_query($c,"select * from category_sub where p_id='".$id."'");
			$category_count = mysqli_num_rows($category);
			
			$sms_sub = mysqli_query($c,"select * from message_sub where cat_id='".$id."'");
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
						
						$msg_sub = mysqli_query($c,"select * from message_sub where cat_id='".$all_category_id."'");
						$all_sms = mysqli_num_rows($msg_sub);
						
						$get_all_delete_id = getParentID($all_category_id);
						foreach($get_all_delete_id as $get_p_all_delete_id)
						{
							if($get_p_all_delete_id!=0)
							{
								$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$get_p_all_delete_id."'");
							}
						}
						
						$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$all_category_id."'");
						
						while($msg_sub_data = mysqli_fetch_array($msg_sub))
						{
							$msg_sub_msg_id = $msg_sub_data["sms_id"];	
							$msg_delete = mysqli_query($c,"delete from message where id='".$msg_sub_msg_id."'");
						}
						$msg_sub_delete = mysqli_query($c,"delete from message_sub where cat_id='".$all_category_id."'");
						
						$delete_category = mysqli_query($c,"delete from category where cat_id='".$all_category_id."'");
						$delete_category_sub = mysqli_query($c,"delete from category_sub where cat_id='".$all_category_id."'");						
						
					}  
				}
			}
			if($sms_sub_count>=1)
			{
				$all_sms = $sms_sub_count;
				
				$get_all_delete_id = getParentID($id);
				foreach($get_all_delete_id as $get_p_all_delete_id)
				{
					if($get_p_all_delete_id!=0)
					{
						$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$get_p_all_delete_id."'");
					}
				}
				
				$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$id."'");
				
				while($sms_sub_data = mysqli_fetch_array($sms_sub))
				{	
					$sms_sub_sms_id = $sms_sub_data["sms_id"];
					$sms_delete = mysqli_query($c,"delete from message where id='$sms_sub_sms_id'");
				}
				$msg_sub_delete = mysqli_query($c,"delete from message_sub where cat_id='$id'");
			}
			
			$delete_category = mysqli_query($c,"delete from category where cat_id='$id'");
			$delete_category_sub = mysqli_query($c,"delete from category_sub where cat_id='$id'");
			
			header("location:$adminurl/home.php?id=$pid");
			
		}
		
		delcat($id);
						
	}
	else
	{
		echo "Sorry Id Not Found";
	}
	
	
}

				
function getParentID($c_id)
{	

	global $c;
	global $adminhome;
	global $adminurl;

	$cat_sub_id = mysqli_query($c,"select * from category where cat_id='$c_id'");
	while($cat_sub_id_data = mysqli_fetch_array($cat_sub_id))
	{
		$cat_sub_pid = $cat_sub_id_data["p_id"];
		$cat_sub_p_id[] = $cat_sub_pid;
		getParentID($cat_sub_pid);
	}
	if(isset($cat_sub_p_id))
	{
		return $cat_sub_p_id;
	}
}
	
?>
	