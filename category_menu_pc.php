<?php

	require_once("connect.php");
	
	require_once("names.php");
	require_once("counter.php");
	
	$root_category = 185;
?>

<html>
<head>
  
</head>
<body>


	<div class="col-md-4 visible-lg">
    
            <ul class="w3-ul w3-card-4">
              <li class="w3-cyan"> <center> Categories </center> </li>
           </ul>
           
           <div class="list-group">
              <ul class="w3-ul w3-card-4">
                 	<?php
							$category_sub = mysqli_query($c,"select * from category_sub where p_id=$root_category order by cat_order");
							while($category_sub_data = mysqli_fetch_array($category_sub))
							{
								$category_sub_cat_id = $category_sub_data["cat_id"];
								
								$category = mysqli_query($c,"select * from category where cat_id=$category_sub_cat_id AND status='Active'");
								while($category_data = mysqli_fetch_array($category))
								{
									$cat_id = $category_data["cat_id"];
									$cat_name = $category_data["cat_name"];
									$cat_rename = str_replace(array(" ","(",")"),array(""),$cat_name);
									$new = $category_data["new"];
									$all_sms = $category_data["all_sms"];
						?>
                        <li> 
                        	<a href="<?php echo $url; ?>/category/<?=$cat_id?>/<?=$cat_rename?>" title="<?php echo $cat_name; ?>" class="list-group-item">
                            	 <?php echo $cat_name; ?>
                                  <span class="badge"> <?php echo $all_sms; ?> </span>
                           </a> 
                       </li>
                        <?php
								}
							}
						?>
                 </ul>
            </div>
    </div>
	   
	 <nav class="navbar navbar-default visible-md visible-sm visible-xs">
    	<div class="container-fluid">
        	<div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#categpry">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>        	
	            </button> 
                
            	<a href="" class="navbar-brand"> Categories </a>
            </div>
            <div class="collapse navbar-collapse" id="categpry">
            	<ul class="nav navbar-nav navbar-right">
						<!--	
						<li data-role="list-divider"> <center> By </center> </li>
						
						 <li> <a href="<?php //echo $url; ?>/last/updated/sms/new2old/page/1" class="list-group-item"> Last / Latest Updated Sms </a> </li>
						<li> <a href="<?php //echo $url; ?>/popular/most/sms/new2old/page/1" class="list-group-item"> Popular Sms </a> </li>
                        <li> <a href="<?php //echo $url; ?>/top/user/page/1" class="list-group-item"> Top User </a> </li>
						
						<li data-role="list-divider"> <center> Category </center> </li>
						-->
						
                    	<?php
							$category_sub = mysqli_query($c,"select * from category_sub where p_id=$root_category order by cat_order");
							while($category_sub_data = mysqli_fetch_array($category_sub))
							{
								$category_sub_cat_id = $category_sub_data["cat_id"];
								
								$category = mysqli_query($c,"select * from category where cat_id=$category_sub_cat_id");
								while($category_data = mysqli_fetch_array($category))
								{
										$cat_name = $category_data["cat_name"];
										$cat_rename = str_replace(array(" ","(",")"),array(""),$cat_name);
										$cat_id = $category_data["cat_id"];
										$all_sms = $category_data["all_sms"];
							?>
                            <li>
								<a href="<?php echo $url; ?>/category/<?=$cat_id?>/<?=$cat_rename?>" title="<?php echo $cat_name; ?>" class="list-group-item"> 
								<?php echo $cat_name; ?> 
								<span class="badge"> <?php echo $all_sms; ?> </span>
								</a>  
							</li>
							<?php
								}
							}
							?>
                 </ul>
        </div>
    </div>
  	</nav>
	   
</body>
</html>