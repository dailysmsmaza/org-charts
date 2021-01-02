<?php
	require_once('createEmoji.php');

	include("header.php");
	require_once("connect.php");
	require_once("names.php");
	
	require_once("createDBController.php");

	$ip_address = $_SERVER['REMOTE_ADDR'];

	$adDisplay = 0;
?>

<!DOCTYPE html>
<html>
<head>
	
    <title> Popular SMS :  <?php echo $title; ?> </title> 
	
	<meta name="robots" content="index,follow">
	<meta name="title" content="Popular SMS : <?php echo $title; ?>">
	<meta name="keywords" content="Popular jokes sms or messages, all time hit sms, users like, most usable or viewable sms :: <?php echo $title; ?>">
	<meta name="description" content="Popular jokes sms which is liked by the user to see in top most in popular page :: <?php echo $title; ?>">  
	
	<script>
	function addLikes(id,action) {
		$.ajax({
		url: "<?php echo $url; ?>/add_likes.php",
		data:'id='+id+'&action='+action,
		type: "POST",
		beforeSend: function(){
			$('#sms-'+id+' .btn-likes').html("<img src='<?php echo $url; ?>/images/LoaderIcon.gif' />");
		},
		success: function(data){
		var likes = parseInt($('#likes-'+id).val());
		switch(action) {
			case "like":
			$('#sms-'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\')" />');
			likes = likes+1;
			break;
			case "unlike":
			$('#sms-'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\')" />')
			likes = likes-1;
			break;
		}
		$('#likes-'+id).val(likes);
		if(likes>0) {
			$('#sms-'+id+' .label-likes').html(likes+" Like(s)");
		} else {
			$('#sms-'+id+' .label-likes').html('');
		}
		}
		});
	}
	</script>
	
	<base href="/">
		
</head>
<body>
	
	<?php include_once("analyticstracking.php"); ?>


<script src="dist/clipboard.min.js"></script> 

	<?php
		include("dist/copy_sms.php");
		
		include("category_menu_pc.php");
	?>

		<div class="col-sm-6">
        	<ul class="w3-ul w3-card-4">
                  <li class="w3-cyan"> <center> Most Popular SMS </center> </li>
            </ul>
        	
            <?php
				
				$adjacents = 2;
				$targetpage = $url."/popular/most/sms/new2old/page";
				
				$default_limit = mysqli_query($c,"select * from default_id where id=2");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$limit = $default_limit_pid[2];
				
				$default_limit = mysqli_query($c,"select * from default_id where id=4");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$msg_limit = $default_limit_pid[2];
				
				/*$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='".$ip_address."'");
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
				}*/
	
				/*if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$pages_query = mysqli_query($c,"select count(id) from message where lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."' AND status='Active' order by likes");
				}
				else
				{
					$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by likes");
				}*/
				
				$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by likes");
				
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
				include("paging.php");
				
				/*if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$msg = mysqli_query($c,"select * from message where status='Active' AND lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."' order by likes desc LIMIT $start,$limit");
				}
				
				else
				{
					$msg = mysqli_query($c,"select * from message where status='Active' order by likes desc LIMIT $start,$limit");
				}*/
				
				$msg = mysqli_query($c,"select * from message where status='Active' order by likes desc LIMIT $start,$limit");
				
				while($msg_data = mysqli_fetch_array($msg))
				{
					/*if($adDisplay%3==0 && $adDisplay!=0){
						// echo "adDisplay: "+$adDisplay;
						?>
						<a href="https://play.google.com/store/apps/details?id=com.madhavgames.kiteflying">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/download_now.png" alt="Music + Ringtone Folder Player"> 
						</a>
						<?php
						}*/

						$msg_data_sms = $msg_data["sms"];
						$msg_data_user_id = $msg_data["user_id"];
						$msg_data_id = $msg_data["id"];
						
						include("date.php");
						
						$msg_sub = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
						while($msg_sub_data = mysqli_fetch_array($msg_sub))
						{
							$msg_sub_data_cat_id = $msg_sub_data["cat_id"];
						
							$category = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id");
							while($category_data = mysqli_fetch_array($category))
							{	
								$category_cat_name = $category_data["cat_name"];
								$category_cat_id = $category_data["cat_id"];
								$category_cat_re_name = str_replace(array(" ","(",")"),array(""),$category_cat_name);
								
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
						}
						$adDisplay++;
				}
				
				?>
                <center>
				<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" target="_blank">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/mathematics_puzzle.jpg" alt="Mathemateics Puzzle (Mathemateics Quiz)"> 
			</a>
                   <?php
						echo $pagination;
					?>        	
               </center>
           	
         </div>
		 
	
	<!--<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
	</div>-->
		 
		 
	<?php 
	
	function trunc($phrase, $max_words) 
	{
	   $phrase_array = explode(' ',$phrase);
	   if(count($phrase_array) > $max_words && $max_words > 0)
	      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
	   return $phrase;
	}

		require_once("customFunction.php");	

		include("Tags.php"); 
	
		include_once("Back_&_Bottom_to_Top_Jquery.php");
	
		include("footer.php"); 
		
	?>
		
	
	<!-- <a href="javascript:void(0);" id="share" title="Scroll to Top"></a> -->
	
</body>
</html>