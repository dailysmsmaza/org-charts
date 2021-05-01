<?php

$all_sub_categories = array();

function set_categories($c, $pId, $all_sub_categories)
{

	$categories = mysqli_query($c, "select * from category where p_id=$pId");
	while ($categories_data = mysqli_fetch_array($categories)) {
        $cat_id = $categories_data["cat_id"];
        global $all_sub_categories;
		array_push($all_sub_categories, $cat_id);
		set_categories($c, $cat_id, $all_sub_categories);
    }
}

?>