<?php

	include("connect.php");
	
	$old_id = "152";
	
	$new_id = "166";
	
	$cat_msg_count_add = mysqli_query($c,"UPDATE message_sub SET cat_id ='$new_id' WHERE cat_id='$old_id'");

?>