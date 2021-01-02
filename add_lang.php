<?php

if(isset($_POST["insert"]))
{	
		include("connect.php");
		
		$ip_address = $_SERVER["REMOTE_ADDR"];
		
		$ip_address_get = mysqli_query($c,"select * from lang_ipaddress where ip_address='".$ip_address."'");
		$ip_address_count = mysqli_num_rows($ip_address_get);
		
		
		$lang_name = explode(",",$_POST["insert"]);
	
		if($ip_address_count>0)
		{
			$delete_lang = mysqli_query($c,"delete from lang_ipaddress where ip_address='".$ip_address."'");
		}
		
		foreach($lang_name as $all_lang)
		{
			$q = mysqli_query($c,"insert into lang_ipaddress (lang_name,ip_address) values ('$all_lang','$ip_address')");
			echo $all_lang;
		}	
}

?>