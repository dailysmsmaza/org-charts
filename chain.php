<html>
<head>
	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css"> 
</head>
<body>

  <div class="panel panel-info">
    
	<strong> Location | </strong>
	
     
<?php

$id = $_GET["c_id"];
if($id!=0)
{
	
	function getid($id)
	{	
		
		global $c;
		global $adminhome;
		global $adminurl;
		
		$cat_sub_id = mysqli_query($c,"select * from category where cat_id='$id'");
		while($cat_sub_id_data = mysqli_fetch_array($cat_sub_id))
		{
			$cat_sub_pid = $cat_sub_id_data["p_id"];
			$cat_sub_p_id[] = $cat_sub_pid;
			getid($cat_sub_pid);
		}
		if(!empty($cat_sub_p_id))
		{
			foreach($cat_sub_p_id as $cat_pid)
			{
				$cat = mysqli_query($c,"select * from category where cat_id=$cat_pid");
				while($cat_data = mysqli_fetch_array($cat))
				{
					$cat_name = $cat_data["cat_name"];
					$cat_rem_name = str_replace(array(" ","(",")"),array(""),$cat_name); //$cat_rem_name means category special
					$cat_id = $cat_data["cat_id"];
				}
			?>
			<span class="h_chain">
            <?php
            	if($cat_pid==0)
				{
			?>
					&nbsp; <a href="<?php echo $url; ?>"> Home </a>
			<?php
				}
				else
				{
				?>
					&gt;&gt; <a href="<?php echo $url; ?>/category/<?php echo $cat_id; ?>/<?php echo $cat_rem_name; ?>">
                    			 <?=$cat_name?> 
                    		</a> 
			</span>	
		<?php	
				}
			}
		}
	}
	getid($id);
	
	$cur_cat = mysqli_query($c,"select * from category where cat_id='$id'");
	while($cur_cat_data = mysqli_fetch_array($cur_cat))
	{
		$cur_cat_name = $cur_cat_data["cat_name"];
		$cur_cat_rem_name = str_replace(array(" ","(",")"),array(""),$cur_cat_name); //$cat_rem_name means category special
		$cur_cat_id = $cur_cat_data["cat_id"];
	}
	?>
    <span class="h_chain">
		&gt;&gt; <a href="<?php echo $url; ?>/category/<?php echo $cur_cat_id; ?>/<?php echo $cur_cat_rem_name; ?>">
                    			 <?php echo $cur_cat_name; ?> 
                 </a>
	</span>
    <?php
}
else
{
	 ?>
	&nbsp; <a href="<?php echo $url; ?>"> Home </a>
    <?php
}

?>

</div>

<br>

</body>
</html>
