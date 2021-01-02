<?php
	require_once('createEmoji.php');	
	
	include("header.php");
	include("connect.php");
	include("names.php");	
	
	$id = $_GET["c_id"];
	
	$adDisplay = 0;

	require_once("createDBController.php");
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	
	global $counter;
	$cat_id = mysqli_query($c,"select * from category where cat_id=$id");
	while($cat_id_data = mysqli_fetch_array($cat_id))
	{
		$cat_id_status = $cat_id_data["status"];
		if($cat_id_status=="Deactive"){
			header("Location: http://www.dailysmsmaza.com");
			return;
		}
		$cat_id_id = $cat_id_data["cat_id"];
		$cat_id_name = $cat_id_data["cat_name"];
		$cat_id_rename  = str_replace(array(" ","(",")"),array(""),$cat_id_name);
		$cat_id_desc = $cat_id_data["cat_description"];
		$cat_id_title = $cat_id_data["cat_title"];
		$cat_id_random_data = $cat_id_data["random_app_data"];
	}

	if(isset($_GET["c_id"]) && isset($_GET["page"]) )
	{
		$get_page_cat_id = $_GET["c_id"];
		$get_page_page = "page".$_GET["page"];
		
		$get_page = mysqli_query($c,"select * from page_detail where page_number='".$get_page_page."' AND cat_id='".$get_page_cat_id."'");
		
		while($get_page_data = mysqli_fetch_array($get_page))
		{
			$get_page_keywords = $get_page_data["keywords"];
			$get_page_description = $get_page_data["description"];
		}
		
	}
	/*
	function truncate_words($trunc_msg_data_sms, $trunc_msg_limit, $trimmarker) 
	{
		$trunc_count = str_word_count($trunc_msg_data_sms, 0);
		$trunc_msg_data_sms = explode(' ', $trunc_msg_data_sms, $trunc_msg_limit + 1);
		array_pop($trunc_msg_data_sms);
		$trunc_msg_data_sms = implode(' ', $trunc_msg_data_sms);
		return ($trunc_msg_limit < $trunc_count) ? $trunc_msg_data_sms . $trimmarker : $trunc_msg_data_sms;
	}
	*/
?>	

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<meta name="robots" content="index,follow">
	
    <base href="/">

    <title> <?php echo $cat_id_title; ?> :: <?php echo $title; ?> </title>
	
    <meta name="title" content="<?php echo $cat_id_title; ?> :: <?php echo $title; ?>">
	<meta name="keywords" content="<?php if(!empty($get_page_keywords)) { echo $get_page_keywords; } else { echo $cat_id_title; }?>">
	<meta name="description" content="<?php if(!empty($get_page_description)) { echo $get_page_description; } else { echo $cat_id_title; }?>">  
        
    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css"> 
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">
    
	
	
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
	

	<script>
	
	$(function () {
	
		$(document).on('click', '.trigger', function () {
			$(this).addClass("on");
			$(this).tooltip({
				items: '.trigger.on',
				position: {
					my: "left+30 center",
					at: "right center",
					collision: "flip"
				},
				delay:1000
			});
			$(this).trigger('mouseenter');
		});		
	});
	
	</script>
	
	
</head>
<body>

<?php include_once("analyticstracking.php"); ?>

	 <script src="dist/clipboard.min.js"></script>
         	
<?php
	include("dist/copy_sms.php");

	include("category_menu_pc.php");
	
	include("customFunction.php");
		
	$adjacents = 2;
	
	$targetpage = $url."/sms/".$id."/".$cat_id_rename."/page";
	
	
	$default_limit = mysqli_query($c,"select * from default_id where id=2");
	$default_limit_pid = mysqli_fetch_row($default_limit);
	$limit = $default_limit_pid[2];
	
	$default_limit = mysqli_query($c,"select * from default_id where id=4");
	$default_limit_pid = mysqli_fetch_row($default_limit);
	$msg_limit = $default_limit_pid[2];
	
	/*$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='$ip_address'");
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
		$pages_query = mysqli_query($c,"SELECT count(id) FROM message_sub WHERE cat_id='".$id."' AND sms_id IN (SELECT id FROM message WHERE lang='".$english."' OR lang='".$hindi."' OR lang='".$gujarati."') order by id desc");
	}
	else
	{
		$pages_query = mysqli_query($c,"select count(id) from message_sub where cat_id='$id' order by id desc");
	}
	*/
	
	$pages_query = mysqli_query($c,"select count(id) from message_sub where cat_id='$id' order by id desc");
	
	$pages_row = mysqli_fetch_row($pages_query);
	$total_records = $pages_row[0];
	

	include("paging.php");

?>

	
			<div class="col-md-6"> 
				<?php include_once("chain.php"); ?>
				<ul class="w3-ul w3-card-4">
					<li class="w3-cyan"> 
						<center> 
							<?php echo $cat_id_name; ?> 
							<span class="badge"> 
								<?php echo $total_records; ?> 
								SMS 
							</span> 
						</center> 
					</li>
				</ul>
               
				<?php
				// order by sms_id desc LIMIT $start,$limit
				/*if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' AND  sms_id IN (SELECT id FROM message WHERE lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."') order by id desc LIMIT $start,$limit");
				}
				else
				{
					$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' order by id desc LIMIT $start,$limit");
				}
				*/
					if($cat_id_random_data=="1"){
						$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' order by RAND() LIMIT $start,$limit");
					} else {
						$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' order by id desc LIMIT $start,$limit");
					}
						
					$sub_message_count = mysqli_num_rows($sub_message);
				
					if($sub_message_count>0)
					{
						while($sub_message_data = mysqli_fetch_array($sub_message))
						{
							/*if($adDisplay%3==0 && $adDisplay!=0){
							// echo "adDisplay: "+$adDisplay;
							?>
							<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.photorecoverypro" target="_blank">
								<img class="img-responsive" src="http://www.dailysmsmaza.com/images/photo_recovery_pro.png" alt="Photo Recovery Pro (Restore Deleted Photos)"> 
							</a>
							<!-- <a href="https://play.google.com/store/apps/details?id=com.happytechsolution.photorecoverypro" target="_blank">
								<img class="img-responsive" src="http://www.dailysmsmaza.com/images/photo_recovery_pro.png" alt="Photo Recovery Pro (Restore Deleted Photos)"> 
							</a> -->
							<?php
							}*/

							$sub_message_sms_id = $sub_message_data["sms_id"];
							
							$msg = mysqli_query($c,"select * from message where id='".$sub_message_sms_id."' AND status='Active'");
			
							while($msg_data = mysqli_fetch_array($msg))
							{
								$msg_data_id = $msg_data["id"];
								$msg_data_sms = $msg_data["sms"];
								$msg_data_user_id = $msg_data["user_id"];
								
								//$trimmarker = "... <a href=''> Read More </a>";
				
								//$msg_data_sms = truncate_words($msg_data_sms,$msg_limit,$trimmarker);
				
								
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
					 		$adDisplay++;
						}
					}
					else
					{
						?>
						<ul class="w3-ul w3-card-4">
							<div class="alert alert-danger">
								<center>
									<strong>Sorry ! </strong> No SMS Found..
								</center>
							</div>
					</ul>
					<?php
					}
					?>
 
  		<!-- <center> 
		 <a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" target="_blank">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/mathematics_puzzle.jpg" alt="Mathemateics Puzzle (Mathemateics Quiz)"> 
			</a>
 			 <?php echo $pagination; ?>   
 		 </center> -->
		 
       </div>
    
	</div>

	<!--<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
	</div>-->
		
		
	<?php 
		
		require_once("customFunction.php");	

		include("Tags.php"); 
	
		include("Back_&_Bottom_to_Top_Jquery.php"); 
		
		include_once("footer.php"); 
		
	?>

</body>
</html>