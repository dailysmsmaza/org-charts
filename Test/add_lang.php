<?php

include("connect.php");

for($i=0;$i<50;$i++)
{	
	if(isset($_POST["r$i"]))
	{
		$lang = $_POST["r$i"];
				
		$split=split("[0-9]",$lang);
		$alpha=$split[(sizeof($split))-1];
		$number=explode($alpha, $lang);
		
		$id = $number[0];
		$lang_name = $alpha;
		
		$lang_insert = mysqli_query($c,"update message set lang='".$lang_name."' where id='".$id."'");
		header("location:Lang.php");
	}
}




?>