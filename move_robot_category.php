<?php

set_time_limit(0);

require_once("header.php");
require_once("connect.php");
include("counter.php");

/*
$category_id = "225";
echo getcounter($category_id);
*/

for($i=1729;$i<=5197;$i++){
    $one_sms_category = mysqli_query($c,"select * from category where cat_id=$i AND p_id='0' AND cat_name like 'A%' ");
    while($one_sms_category_data = mysqli_fetch_array($one_sms_category))
	{
        //echo $one_sms_category_all_sms = $one_sms_category_data["all_sms"];

        $id = $one_sms_category_data["cat_id"];
		echo $name = $one_sms_category_data["cat_name"];

		$cha_pid = "225";
		// $category_upd = mysqli_query($c,"update category_sub set p_id=$cha_pid where cat_id=$id");
		// $category_upd = mysqli_query($c,"update category set p_id=$cha_pid where cat_id=$id");
	}
}

?>