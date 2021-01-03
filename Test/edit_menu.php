<?php

	ob_end_flush();
	ob_start();

	include("names.php");
	include("connect.php");
	
	$id = $_GET["id"];
	
	$default_id = mysqli_query($c,"select * from default_id where id=$id");
	while($default_id_data = mysqli_fetch_array($default_id))
	{
		$default_id_name = $default_id_data["name"];
		$default_id_pid = $default_id_data["pid"];
	}
	
?>	

<!DOCTYPE html>
<html lang="en">
  <head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/w3.css" rel="stylesheet">
	<style>
		body { padding-top: 60px; }
		table { width: 100%; }
		td, th {text-align: left;	word-wrap: break-word;}
		h2, h3 {margin-top: 1em;}
		section {padding-top: 40px;}
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="assets/css/no-more-tables.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
  </head>
<body>


    <?php 
			include("header.php");			
	?>

<ul class="w3-ul w3-card-4">
	 <h4> <center> Edit Default Menu </center> </h4>
	 
<div class="container">

  <form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" name="name" value="<?=$default_id_name?>" style="width:60%;height:5%" disabled >
    </div>
    <div class="form-group">
      <label for="pwd">Default:</label>
      <input type="text" class="form-control" name="pid" value="<?=$default_id_pid?>" style="width:60%;height:5%">
    </div>
	
	<br>
	
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input class="btn btn-success" type="submit" name="submit" value="Save" />
		<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
  </form>
</div>

</ul>

		
  <script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/prettify.js"></script>
	<script>
		$(function(){
			prettyPrint();
		});
	</script>
  </body>
</html>


<?php	
	
	if(isset($_POST["submit"]))
	{
		
			$p_id = $_POST["pid"];
			$id = $_POST["id"];
			
			$default_update = mysqli_query($c,"update default_id set pid='".$p_id."' where id='".$id."'");
			
			$limit = $p_id;
			
			if($id==2)
			{
				
				$category = mysqli_query($c,"select * from category");
				while($category_data = mysqli_fetch_array($category))
				{
					$cat_id = $category_data["cat_id"];
					
					$pages_query = mysqli_query($c,"select count(id) from message_sub where cat_id='".$cat_id."'");
					$pages_row = mysqli_fetch_row($pages_query);
					$total_records = $pages_row[0];
					echo $total_pages = ceil($total_records/$limit);
					
					$page_all = mysqli_query($c,"SELECT count(id) FROM page_all WHERE cat_id='".$cat_id."'");
					$page_all_row = mysqli_fetch_row($page_all);
					echo $total_page_all = $page_all_row[0];
					
					
					if( $total_pages > $total_page_all )
					{
						for($i=$total_page_all+1;$i<=$total_pages;$i++)
						{
							$page_number = "page".$i;
							$page_insert = mysqli_query($c,"INSERT INTO page_all (page_number,cat_id) VALUES ('".$page_number."','".$cat_id."')");
						}	
					}
					else if( $total_pages < $total_page_all )
					{
						for($i=$total_pages+1;$i<=$total_page_all;$i++)
						{
							$page_number = "page".$i;
							$page_insert = mysqli_query($c,"DELETE FROM page_all WHERE page_number='".$page_number."' AND cat_id='".$cat_id."'");
						}	
					}
					else
					{	
					}
					echo "<br>";
				}
			}
			header("location:$adminurl/default_menu.php");
	}
	
?>