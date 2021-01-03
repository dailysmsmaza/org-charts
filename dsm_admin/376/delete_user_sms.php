<?php
	ob_end_flush();
	ob_start();
	session_start(); 
	include("names.php");
	include("my_function.php");

if(isset($_SESSION["username"]))
{
	include("header.php");
	require("connect.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
	
	$id = $_GET["id"];
	
	$delete_msg = mysqli_query($c,"delete from user_message where id='$id'");
	mysqli_close($c);
	
	?>
	<script> 
			page_call("add_user_messages.php");  
    </script>
	<?php
}
	
else
{
	 ?>    
		<script> 
			page_call("home.php?id=0"); 
        </script>  
    <?php

}

?>