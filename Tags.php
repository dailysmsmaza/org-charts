<html>

<head>
	

</head>

<body>

<!--
<div class="col-lg-12 visible-xs visible-sm">

<script>
  (function() {
    var cx = '012796279365031235966:zp1thelpsp4';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
</div>
-->

		 <div class="col-lg-12 visible-xs visible-sm">

			<ul class="w3-ul w3-card-4">
				<li class="w3-cyan"> <center> All Tags / Category </center> </li>
			</ul>
		
			<ul class="w3-ul w3-card-4">
			
			
				<?php
				
						$badge_color = array("error","warning","success","info","inverse");
					
						$i = 0;
					
						require_once("connect.php");
						require_once("names.php");
						
						$category_sub = mysqli_query($c,"select * from category_sub where p_id=0 order by cat_order");
						while($category_sub_data = mysqli_fetch_array($category_sub))
						{
							$category_sub_cat_id = $category_sub_data["cat_id"];
							
							$category = mysqli_query($c,"select * from category where cat_id=$category_sub_cat_id");
							while($category_data = mysqli_fetch_array($category))
							{
								$cat_id = $category_data["cat_id"];
								$cat_name = $category_data["cat_name"];
								$cat_rename = str_replace(array(" ","(",")"),array(""),$cat_name);
								$new = $category_data["new"];
								
								?>
								
								<span class="badge badge-<?php echo $badge_color[$i]; ?>"> 
									<!--<h6> -->
										<a href="<?php echo $url; ?>/category/<?=$cat_id?>/<?=$cat_rename?>" style="color:white;"> 
											<?php echo $cat_name; ?> 
										</a> 
									<!--</h6>-->
								</span>
								<?php
								
								if($i>4)
								{
									$i = 0;
								}
								else
								{
									$i++;
								}
							}
						}
						?>
						<span class="badge badge-<?php echo $badge_color[$i]; ?>"> 
									<!--<h6> -->
										<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.app.security.applocker" style="color:white;"> 
											<?php echo "Indian #1 Playstore AppLocker, Vault(Photo, Video), Call Blocker Pro App for Android"; ?> 
										</a> 
									<!--</h6>-->
								</span>
								
								<span class="badge badge-<?php echo $badge_color[$i]; ?>"> 
									<!--<h6> -->
										<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" style="color:white;"> 
											<?php echo "Indian #1 Mathematics puzzle Pro (Brain Test, Learning) App for Android"; ?> 
										</a> 
									<!--</h6>-->
								</span>
								
						<?php
										
				?>
				
			</ul>
		
		</div>

	<br>
	
</body>
</html>