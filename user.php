<?php
	require_once('createEmoji.php');	
	
	include("header.php");
	require("connect.php");
	include("names.php");
	
	require_once("createDBController.php");

	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	if(isset($_GET["u_id"]))
	{
		$u_id = $_GET["u_id"];
	}
	
	 $user = mysqli_query($c,"select * from user where user_id=$u_id");
	 while($user_data = mysqli_fetch_array($user))
	{			
		$user_name = $user_data["username"];
		$user_id = $user_data["user_id"];
	 }
	
	$adDisplay = 0;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	 
     <base href="/">
     
	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">
    
  	<title> <?php echo $user_name; ?> SMS :: DailySmsMaza.com</title>

	<meta name="keywords" content="<?php echo $user_name; ?> SMS :: facebook, whatsapp, twitter, linkedin, imo, account">
	<meta name="description" content="<?php echo $user_name; ?> SMS Messages :: facebook, whatsapp, twitter, linkedin, imo, account Funny Jokes SMS Quotes, Shayari,">
    
	
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
?>
        
        
	      <?php
	
				$adjacents = 2;
				$targetpage = $url."/user/sms/".$u_id."/page";
				
				$default_limit = mysqli_query($c,"select * from default_id where id=2");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$limit = $default_limit_pid[2];
			
				/*$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='$ip_address'");
				$get_lang_count = mysqli_num_rows($get_lang);
				while($get_lang_data = mysqli_fetch_array($get_lang))
				{
					$language = $get_lang_data["lang_name"];
				}
				if($language == "English" OR $language == "Hindi" OR $language == "Gujarati")
				{
					$pages_query = mysqli_query($c,"select count(id) from message where user_id='".$u_id."' AND status='Active' AND lang='".$language."' order by id desc");
				}
				else
				{
					$pages_query = mysqli_query($c,"select count(id) from message where user_id='".$u_id."' AND status='Active' order by id desc");
				}
				*/
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
			
				include("paging.php");		
			
			 
		  ?>

		<div class="col-sm-6">
        	<ul class="w3-ul w3-card-4">
            	 <li class="w3-cyan"> 
                 	<center> 
                    	User : 
						<?php echo $user_name; ?>
                        <span class="badge"> <?php echo $total_records; ?> SMS </span> 
                   </center> 
                </li>
       	    </ul> 
    
		<?php
		
			/*if($language == "English" OR $language == "Hindi" OR $language == "Gujarati")
			{
				$message = mysqli_query($c,"select * from message where user_id='$u_id' AND status='Active' AND lang='".$language."' order by id desc LIMIT $start,$limit");
			}
			else
			{
				$message = mysqli_query($c,"select * from message where user_id='$u_id' AND status='Active' order by id desc LIMIT $start,$limit");
			}*/
		
			$message = mysqli_query($c,"select * from message where user_id='$u_id' AND status='Active' order by id desc LIMIT $start,$limit");
			
			while($msg_data = mysqli_fetch_array($message))
			{

				if($adDisplay%3==0 && $adDisplay!=0){
						// echo "adDisplay: "+$adDisplay;
						?>
						<a href="https://play.google.com/store/apps/details?id=com.in.musicringtone.player&hl=en_IN">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/download_now.png" alt="Music + Ringtone Folder Player"> 
						</a>
						<?php
						}


				$msg_data_sms = $msg_data["sms"];
				$msg_data_user_id = $msg_data["user_id"];
				$msg_data_id = $msg_data["id"];
			
				include("date.php");
			
						
				?>
                
				<?php include("sms_content.php"); ?>				
    
				<?php
					$adDisplay++;										
				}
				
				?>
                <center>
                   <?php
						echo $pagination;
					?>        	
               </center>
           	
         </div>
		 

		 <!--<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
		</div>-->
		 
		 <?php 
			
			require_once("customFunction.php");	

			include("Tags.php"); 
		
			include_once("Back_&_Bottom_to_Top_Jquery.php");
		
			include_once("footer.php"); 
		
		?>
		 
		 
</body>
</html>