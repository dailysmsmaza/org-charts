<?php

		include("names.php");
		include("header.php");
		// require("connect.php");
		include_once("counter.php");
			
		$id = $_GET["c_id"];
		
		$cat_id = mysqli_query($c,"select * from category where cat_id=$id");

		while($cat_id_data = mysqli_fetch_array($cat_id))
		{
			$cat_id_status = $cat_id_data["status"];

			$cat_id_id = $cat_id_data["cat_id"];
			$cat_id_name = $cat_id_data["cat_name"];
			$cat_id_rename  = str_replace(array(" ","(",")"),array(""),$cat_id_name);
			$cat_id_desc = $cat_id_data["cat_description"];
			$cat_id_title = $cat_id_data["cat_title"];
		}

		$adDisplay = 0;	
?>

<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
   
	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
	<link href="<?php echo $url; ?>/style.css" rel="stylesheet">

    <title> <?php echo $cat_id_name; ?> :: <?php echo $title; ?> </title>

	<meta name="robots" content="index,follow">
	<meta name="title" content="<?php echo $cat_id_name; ?> :: <?php echo $title; ?>">
	<meta name="keywords" content="<?php echo $cat_id_title; ?>">
	<meta name="description" content="<?php echo $cat_id_desc; ?>">
	
	
</head>

<body>

<?php include_once("analyticstracking.php"); ?>

<?php
	include("category_menu_pc.php");
?>

				
<div class="col-sm-6">
		<?php include("chain.php"); ?>
                <ul class="w3-ul w3-card-4">
                  <li class="w3-cyan"> <center> <?php echo $cat_id_name; ?> </center> </li>
               </ul>
           
    		   <div class="list-group">
               	  <ul> </ul>
            	  <ul class="w3-ul w3-card-4">
				
				<?php
				
				$sub_category = mysqli_query($c,"select * from category_sub where p_id='$id'  order by cat_order");
				$sub_category_count = mysqli_num_rows($sub_category);
			
				$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$id'");
				$sub_message_count = mysqli_num_rows($sub_message);
				
				if($sub_category_count >= 1)
				{
					while($sub_category_data = mysqli_fetch_array($sub_category))
					{
						/*if($adDisplay%3==0 && $adDisplay!=0){
							// echo "adDisplay: "+$adDisplay;
							?>
							<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.photorecoverypro" target="_blank">
								<img class="img-responsive" src="http://www.dailysmsmaza.com/images/photo_recovery_pro.png" alt="Photo Recovery Pro (Restore Deleted Photos)"> 
							</a>
							<!-- <a href="https://play.google.com/store/apps/details?id=com.in.musicringtone.player&hl=en_IN">
								<img class="img-responsive" src="http://www.dailysmsmaza.com/images/download_now.png" alt="Music + Ringtone Folder Player"> 
							</a> -->
							<?php
						}*/

						$sub_category_pid = $sub_category_data["cat_id"];
	
						$category = mysqli_query($c,"select * from category where cat_id='$sub_category_pid' && status='Active' order by cat_order");
						while($category_data = mysqli_fetch_array($category))
						{
							$cat_id = $category_data["cat_id"];
							$cat_name = $category_data["cat_name"];
							$cat_rem_name = str_replace(array(" ","(",")"),array(""),$cat_name); //$cat_rem_name means category special character removed name
							$cat_title = $category_data["cat_title"];
							$cat_desc = $category_data["cat_description"];
							$cat_all_sms = $category_data["all_sms"];
						?>
                        	<li> 
                            	<a href="<?php echo $url; ?>/category/<?=$cat_id?>/<?=$cat_rem_name?>" class="list-group-item"> 
                                	<span class="glyphicon glyphicon-hand-right"> </span> &nbsp; <?php echo $cat_name; ?>
									<span class="badge"> <?php echo $cat_all_sms; ?> </span>
 
                                    <!--<span class="badge"> <?php //echo getcounter($cat_id); ?> </span> -->
                                </a> 
                           </li>
                        <?php
						}
						$adDisplay++;
					}
				}
				else
				{
					header("location:$url/sms/$cat_id_id/$cat_id_rename/page/1");
				}
			
	?>

</div>
</div>
	
	
	
	
	<!--<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
	</div>-->
		 
		 
	<?php 
		include("Back_&_Bottom_to_Top_Jquery.php"); 
		include("Tags.php"); 
	?>
	
</body>
</html>