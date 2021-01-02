<?php
	

	include("header.php");
	include("names.php");
	require("connect.php");
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">
    
    <title> Top User :: www.<?php echo $url; ?>.com </title>
    
</head>
<body>

<?php include_once("analyticstracking.php"); ?>

<?php	include("category_menu_pc.php"); ?>

	<div class="col-sm-6">

        <ul class="w3-ul w3-card-4">
             <li class="w3-cyan"> <center> Top Users </center> </li>
        </ul>

		<div class="list-group">
               	 
			<ul> </ul>
			<ul class="w3-ul w3-card-4"> 
	
			<?php
	
				$adjacents = 2;
				$targetpage = $url."/top/user/page";
				
				$default_limit = mysqli_query($c,"select * from default_id where id=2");
				$default_limit_pid = mysqli_fetch_row($default_limit);
				$limit = $default_limit_pid[2];
			
				$pages_query = mysqli_query($c,"select count(user_id) from user order by user_id desc");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
			
				include("paging.php");
							
				$user = mysqli_query($c,"select * from user order by user_id LIMIT $start,$limit");
				
				while($user_data = mysqli_fetch_array($user))
				{
						$user_id = $user_data['user_id'];
						$user_name = $user_data['username'];
						
						$user_count = mysqli_query($c,"select count(id) from message where user_id='$user_id'");
						$user_count_dt = mysqli_fetch_row($user_count);
										
			?>
			
                
						<li>  
							<a href="<?php echo $url; ?>/user/sms/<?php echo $user_id; ?>/page/1" class="list-group-item">
								<span class="glyphicon glyphicon-hand-right"> 
								</span> 
								&nbsp;
									
								<?php echo $user_name; ?>
								<span class="badge"> 
									<?php echo $user_count_dt[0]; ?> 
								</span> 
							</a>
						</li>
                 
                    
			   <?php
				}
			   ?>
		
			</ul> 
		</div>
	
	   
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
		
		include("Tags.php"); 
	
		include_once("Back_&_Bottom_to_Top_Jquery.php");
	
		include_once("footer.php"); 
		
	?>
		
		
</body>
</html>


