<?php

	ob_end_flush();
	ob_start();
	
	include("names.php");
	include("header.php");
	
if(empty($_SESSION[$s_name]))
{
	header("location:$url/");
}
else
{
	$site_user_name = $_SESSION[$s_name];
	$site_user_id = $_SESSION[$s_id];
	
	require("connect.php");
	
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
?>

<!DOCTYPE html>
<html>
<head>
 
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
    <base href="/">
    
        
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
	?>

	<div class="col-sm-6">
    
            <?php					
					
					$adjacents = 2;
							
					$targetpage = $url."/mysms/all";
							
					$default_limit = mysqli_query($c,"select * from default_id where id=2");
					$default_limit_pid = mysqli_fetch_row($default_limit);
					$limit = $default_limit_pid[2];
						
					$pages_query = mysqli_query($c,"select count(id) from message where user_id='$site_user_id' order by id desc");
					$pages_row = mysqli_fetch_row($pages_query);
					$total_records = $pages_row[0];

			
					include("paging.php");
				
					?>
					
					<ul class="w3-ul w3-card-4">
						<li class="w3-cyan"> <center> <?php echo $site_user_name; ?> <span class="badge w3-black"> <?php echo $total_records; ?> SMS </span> </center> </li>
					</ul>
					
					<?php
					
					$msg = mysqli_query($c,"select * from message where user_id=$site_user_id order by id desc LIMIT $start,$limit");
					$msg_count = mysqli_num_rows($msg);
					
					if($msg_count>0)
					{
							while($msg_data = mysqli_fetch_array($msg))
							{
								$msg_data_id = $msg_data["id"];
								$msg_data_sms = $msg_data["sms"];
								$msg_data_user_id = $msg_data["user_id"];

								
								include("date.php");
																
								$user = mysqli_query($c,"select * from user where user_id=$msg_data_user_id");
								while($user_data = mysqli_fetch_array($user))
								{
									$user_name = $user_data["username"];
										
								?>
						
						<?php include("sms_content.php"); ?>				
						
						<?php	
								}
						}
						?>
						<center>
							<?php echo $pagination;	?>        	
					   </center>
				 </div>
				<?php
				}
				else
				{
					?>
							<ul class="w3-ul w3-card-4">
								<br>
								
								<div class="alert alert-danger">
									<strong>SMS ! </strong> Sorry No SMS Found !
									Click On <a href="<?php echo $url; ?>/addsms/new"> Add SMS </a> To Add Your SMS
								</div>
								
								<br>
							</ul>
					<?php
				}
				?>
		 
</body>
</html>

<?php
}
?>
