<?php
include("connect.php");
include("names.php");
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
</head>
<body>
<div class="path"> 
	<span class="title"> Categories | </span>
    
<?php
	
$id = $_GET["id"];
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
					$cat_id = $cat_data["cat_id"];
				}
			?>
			<span class="h_chain">
            <?php
            	if($cat_pid==0)
				{
			?>
					&nbsp; <a href="<?=$adminhome?>&limit=all"> <font color="#FFFFFF"> Home </font> </a>
			<?php
				}
				else
				{
				?>
					&gt;&gt; <a href="<?=$adminurl?>/home.php?id=<?=$cat_id?>">
                    			<font color="#FFFFFF"> <?=$cat_name?> </font> 
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
		$cur_cat_id = $cur_cat_data["cat_id"];
	}
	?>
    <span class="h_chain">
		&gt;&gt; <a href="home.php?id=<?=$cur_cat_id?>"> <font color="#FFFFFF"> <?=$cur_cat_name?> </font> </a>
	</span>
    <?php
}
else
{
	 ?>
	&nbsp; <a href="<?=$adminhome?>&limit=all"> <font color="#FFFFFF"> Home </font> </a>
    <?php
}
?>


</div>
</body>
</html>
