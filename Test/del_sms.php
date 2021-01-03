<?php
	ob_end_flush();
	ob_start();
	session_start();
	require("connect.php");
	include("names.php");
	
if(isset($_SESSION["username"]))
{
	$id = $_GET["id"];
	$pid = $_GET["pid"];
	
	
	$msg = mysqli_query($c,"delete from message where id='$id'");
	
	$msg_sub_cat = mysqli_query($c,"select * from message_sub where sms_id='$id'");
	while($msg_sub_cat_data = mysqli_fetch_array($msg_sub_cat))
	{
			$msg_cat_id = $msg_sub_cat_data["cat_id"];
			
			$get_all_delete_id = getParentID($msg_cat_id);
			foreach($get_all_delete_id as $get_p_all_delete_id)
			{
				if($get_p_all_delete_id!=0)
				{
					$cat_sms = mysqli_query($c,"update category set all_sms = all_sms - 1 where cat_id='".$get_p_all_delete_id."'");
				}
			}
			
			$cat_sms = mysqli_query($c,"update category set all_sms = all_sms - 1 where cat_id='$msg_cat_id'");						
	}
	
	$msg_sub = mysqli_query($c,"delete from message_sub where sms_id=$id");
	
	if($pid == "search")
	{
		header("location:$adminurl/search_sms.php");
	}
	else
	{
		header("location:$adminurl/home.php?id=$pid");
	}
}
else
{
	header("location:okes36569.php");
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