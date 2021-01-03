<?php

include("connect.php");

$q = mysqli_query($c,"select * from category order by cat_id");
while($r = mysqli_fetch_array($q))
{
	echo $ca_id = $r["cat_id"];
	echo " -> ";
	echo $tot = getcounter($ca_id);
	echo "<br>";
	$up_all = mysqli_query($c,"update category set all_sms='".$tot."' where cat_id='".$ca_id."'");
}
	
	function getcounter($id)
	{
		
		global $c;
		global $adminurl,$no_cat;
		static $sms_count = 0;
		
		$cat = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_name");
		
		while($cat_data = mysqli_fetch_array($cat))
		{
			$cat_id = $cat_data["cat_id"];
			$cat_id_all[] = $cat_id;
			
			$cat_count = mysqli_query($c,"select count(p_id) from category_sub where p_id=$id");
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
				$sms_sub = mysqli_query($c,"select * from message_sub where cat_id=$all_cat_id");
				$sms_coun = mysqli_num_rows($sms_sub);
				$sms_count = $sms_count + $sms_coun;	
			} 
			$sms_count = $sms_count - $sms_coun;
			return $sms_count;
		}
		if(empty($cat_id_all))
		{	
				$sms_sub = mysqli_query($c,"select * from message_sub where cat_id=$id");
				$sms_count = mysqli_num_rows($sms_sub);	
				return $sms_count;
		}
		
	}
	

?>