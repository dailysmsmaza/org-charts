<?php
	require_once('createEmoji.php');
	require("connect.php");
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link href="style.css" rel="stylesheet">
      	
 	<title> Last Updated SMS : <?php echo $title; ?> </title>
	
	<meta name="robots" content="index,follow">
	<meta name="title" content="Last Updated SMS : <?php echo $title; ?>">
	<meta name="keywords" content="Last Updated, Last Uploaded, Last Added, new jokes sms,now sms, current sms, ago sms, hit sms :: <?php echo $title; ?>">
	<meta name="description" content="Last Uploaded by the user or admin sms or jokes for the peoples to share or like :: <?php echo $title; ?>">  

	<base href="/">
	 
</head>
<body>
           
            <?php
				
				$adjacents = 2;
				
				$targetpage = $url."/last/updated/sms/new2old/page";
				
				$default_limit = mysqli_query($c,"select * from default_id where id=2");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$limit = $default_limit_pid[2];
			
				$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='$ip_address'");
				$get_lang_count = mysqli_num_rows($get_lang);
				while($get_lang_data = mysqli_fetch_array($get_lang))
				{
					$language = $get_lang_data["lang_name"];
					if($language=="English")
					{
						$english = "English";
					}
					if($language=="Hindi")
					{
						$hindi = "Hindi";
					}
					if($language=="Gujarati")
					{
						$gujarati = "Gujarati";
					}
				}
			
				if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$pages_query = mysqli_query($c,"select count(id) from message where lang='".$english."' OR lang='".$hindi."' OR lang='".$gujarati."' AND status='Active' order by id desc");
				}
				else
				{
					$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by id desc");
				}
				
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
			
				include("paging.php");
				
				if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$msg = mysqli_query($c,"select * from message where lang='".$english."' OR lang='".$hindi."' OR lang='".$gujarati."' AND status='Active' order by id desc LIMIT $start,$limit");
				}
				else
				{
					$msg = mysqli_query($c,"select * from message where status='Active' order by id desc LIMIT $start,$limit");
				}
				
				while($msg_data = mysqli_fetch_array($msg))
				{
						$msg_data_sms = $msg_data["sms"];
						$msg_data_user_id = $msg_data["user_id"];
						$msg_data_id = $msg_data["id"];
						$msg_data_likes = $msg_data["likes"];
						
						include("date.php");
														
						$user = mysqli_query($c,"select * from user where user_id=$msg_data_user_id");
						while($user_data = mysqli_fetch_array($user))
						{
							$user_id = $user_data["user_id"];
							$user_name = $user_data["username"];
								
						?>
						
				        <?php include("sms_content.php"); ?>
                <?php	
						}
				}
				?>
               