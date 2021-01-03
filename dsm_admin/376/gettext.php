<?php
	include("connect.php");

	$filename = $_POST["filename"];
	
	if($filename!="Select File")
	{
		$get = mysqli_query($c,"select * from advertise where file_name='$filename'");
		while($r = mysqli_fetch_array($get))
		{
			echo $r["file_description"];
		}
	}
	else
	{
		echo "";
	}
?>