<?php

	include("connect.php");
	include("names.php");
	
	/*function getcounter($id)
	{
		
		global $c;
		global $adminurl,$no_cat;
		static $sms_count = 0;
		
		$cat = mysqli_query($c,"select * from category_sub where p_id='$id'");
		
		while($cat_data = mysqli_fetch_array($cat))
		{
			$cat_id = $cat_data["cat_id"];
			$cat_id_all[] = $cat_id;
			
			$cat_count = mysqli_query($c,"select count(p_id) from category_sub where p_id='$id'");
			$cat_counter = mysqli_num_rows($cat_count);
			
			for($i=1;$i<=$cat_counter;$i++)
			{
				getcounter($cat_id);
			}
		}
		
		if(!empty($cat_id_all))
		{
			foreach($cat_id_all as $all_cat_id)
			{
				$sms_sub = mysqli_query($c,"select * from category where cat_id='$all_cat_id'");
				$sms_coun = mysqli_fetch_row($sms_sub);
				$all_sms = $sms_coun[11];
				$sms_count = $sms_count + $all_sms;	
			} 
			$sms_count = $sms_count - $all_sms;
			return $sms_count;
		}
	
		if(empty($cat_id_all))
		{	
				$sms_sub = mysqli_query($c,"select * from category where cat_id='$id'");
				while($sms_sub_coun = mysqli_fetch_array($sms_sub))
				{
					$sms_count = $sms_sub_coun["all_sms"];
					return $sms_count;
				}
		}
		
	}
*/
?>