<?php
	ob_end_flush();
	ob_start();
	include("names.php");
require_once('createEmoji.php');
	
	if(isset($_GET["search"]))
	{
		include("header.php");
		require("connect.php");
		include_once("counter.php");
			
		$search = $_GET["search"];
		
		require_once("dbcontroller.php");
		$db_handle = new DBController();
		$ip_address = $_SERVER['REMOTE_ADDR'];
	
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
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
		
				
				$adjacents = 2;
				
				$targetpage = $url."/search/".$search."/page";
				
				
				$default_limit = mysqli_query($c,"select * from default_id where id=2");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$limit = $default_limit_pid[2];
			
					
				$pages_query = mysqli_query($c,"select count(id) from message where sms LIKE '%$search%' order by likes desc");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
				include("paging.php");
				
?>
				
			<div class="col-sm-6">
                <ul class="w3-ul w3-card-4">
                  <li class="w3-cyan"> <center> Search </center> </li>
               </ul>
           
    		   <div class="list-group">
               	  <ul> </ul>
            	  <ul class="w3-ul w3-card-4">
						
				<?php
				
				$category = mysqli_query($c,"SELECT * FROM category WHERE cat_name LIKE '%$search%' && status='Active' order by cat_order");
				$category_count = mysqli_num_rows($category);
				
				$msg = mysqli_query($c,"select * from message where sms LIKE '%$search%' LIMIT $start,$limit");
				$msg_count = mysqli_num_rows($msg);
				
				?>
				
				
				
				<?php
				if($category_count > 0 )
				{
					?>
					<li class="w3-green"> <center> Category (<?php echo $category_count; ?>) Found </center> </li>
					<?php
					while($category_data = mysqli_fetch_array($category))
					{
						$cat_id = $category_data["cat_id"];
						$cat_name = $category_data["cat_name"];
						$cat_rem_name = str_replace(array(" ","(",")"),array(""),$cat_name); //$cat_rem_name means category special character removed name
						$cat_title = $category_data["cat_title"];
						$cat_desc = $category_data["cat_description"];
					
					?>
											
						<li> 
							<a href="<?php echo $url; ?>/category/<?=$cat_id?>/<?=$cat_rem_name?>" class="list-group-item"> 
								<span class="glyphicon glyphicon-hand-right"> </span> &nbsp; <?php echo $cat_name; ?> 
								<span class="badge"> <?php echo getcounter($cat_id); ?> </span>
							</a> 
					   </li>
					<?php
					}
				}
				else
				{
					?>
						<li class="w3-red"> <center> Category (<?php echo $category_count; ?>) Found </center> </li>
							
					  	<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Sorry !</strong> No Category Found.
						</div>	

					<?php
				}
				?>
				
				<?php
				if($msg_count > 0)
				{ 
						?>
						 <li class="w3-green"> <center> SMS (<?php echo $total_records; ?>) Found </center> </li>
						<?php
						while($msg_data = mysqli_fetch_array($msg))
						{
								$msg_data_id = $msg_data["id"];
								$msg_data_sms = $msg_data["sms"];
								$msg_data_user_id = $msg_data["user_id"];
								
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
				}
				else
				{
					?>
						<li class="w3-red"> <center> SMS (<?php echo $total_records; ?>) Found </center> </li>
							
					  	<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Sorry !</strong> No SMS Found.
						</div>	

					<?php
				}
				?>
				
				
<?php
	}
			?>

</div>
				<center> 
					<?php echo $pagination; ?>   
				</center>
				
</body>
</html>