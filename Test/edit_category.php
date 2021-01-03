<?php
	ob_end_flush();
	ob_start();

	include("names.php");
	require("connect.php");

	$id = $_GET["id"];
	$pid = $_GET["pid"];
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");	
		
?>
<html>
<head>
	
	<title> Edit Category :: <?=$title?> : Admin Panel </title>
	
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
	
	<script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/prettify.js"></script>
	<script>
		$(function(){
			prettyPrint();
		});
	</script>
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	
</head>

<?php	
				
			$category = mysqli_query($c,"select * from category where cat_id=$id");
			while($category_data = mysqli_fetch_array($category))
			{	 
				$cat_id_id = $category_data["cat_id"];
				$cat_id_name = $category_data["cat_name"];
				$cat_id_desc = $category_data["cat_description"];
				$cat_id_title = $category_data["cat_title"];
				$cat_id_status = $category_data["status"];
				$cat_id_new = $category_data["new"];
				$cat_id_updated = $category_data["updated"];
			}
?>

<body>

<?php
include("header.php");
?>

<ul class="w3-ul w3-card-4">

	<h5> <center> Edit Category </center> </h5>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Category Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cat_name" value="<?php echo $cat_id_name?>" style="width:60%;height:5%"/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Description : </label>
			<div class="col-sm-7">
				<textarea class="form-control" name="description" style="width:60%" rows="6"><?=$cat_id_desc?></textarea>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Category Title : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="title" style="width:60%;height:5%" value="<?php echo $cat_id_title; ?>"/>
			 </div>
		</div>
		
		<br>
		<div class="form-group">
			<label class="col-sm-10"> Status : </label>
			<div class="col-sm-7">
				<input type="radio" name="r" value="Active" <?php if($cat_id_status=="Active"){ ?> checked="checked" <?php } ?> > Active
				<input type="radio" name="r" value="Deactive" <?php if($cat_id_status=="Deactive"){ ?> checked="checked" <?php } ?> > Deactive &nbsp;&nbsp;
			</div>
		</div>
		<br>
		<div class="form-group">
			<label class="col-sm-10"> Flag : </label>
			<div class="col-sm-7">
				 <input type="checkbox" name="new" value="1" <?php if($cat_id_new=="1"){ ?> checked="checked" <?php } ?> ><span style="text-align:left;margin-left:0px;"> New</span> &nbsp;&nbsp;
                <input type="checkbox" name="updated" value="1" <?php if($cat_id_updated=="1"){ ?> checked="checked" <?php } ?> ><span style="text-align:left;margin-left:0px;"> Updated</span> &nbsp;&nbsp;		
			</div>
		</div>
		
		<br>
		
		<div class="form-group" style="margin-left:10px">
			<input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
		</div>
		
		<br>
		<br>
		
	</div>
	
	</form>
	
</ul>

</body>
</html>

<?php

	if(isset($_POST["submit"]))
	{
		if(!empty($_POST["cat_name"]) && !empty($_POST["r"]))
		{

			$id = $_POST["id"];
			$pid = $_POST["pid"];
			
			$status = $_POST["r"];
			$cat_name = mysqli_real_escape_string($c,$_POST["cat_name"]);
			$cat_name = trim(ucwords($cat_name));
			
			
			$cat_chk = mysqli_query($c,"select * from category where cat_name='$cat_name' AND cat_id!=$id");
			$cat_chk_count = mysqli_num_rows($cat_chk);
		
			if($cat_chk_count>=1)
			{
				echo "<script> alert('This Category Is Already Exist'); </script>";
			}
		
			else
			{
				$description = mysqli_real_escape_string($c,$_POST["description"]);
				$description =	trim(ucwords($description));
				$cat_title = mysqli_real_escape_string($c,$_POST["title"]);
				$cat_title = trim(ucwords($cat_title));
					
				if(isset($_POST["new"]))
				{
					$new = $_POST["new"];
				}
				else
				{
					$new = "";
				}
				if(isset($_POST["updated"]))
				{
					$updated = $_POST["updated"];
				}
				else
				{
					$updated = "";
				}	
				$category_update = mysqli_query($c,"update category set cat_name='$cat_name',cat_title='$cat_title',cat_description='$description',status='$status',new='$new',updated='$updated' where cat_id=$id");
				
				$category_sub_update = mysqli_query($c,"update category_sub set cat_name='$cat_name' where cat_id=$id");
				
				header("location:$adminurl/home.php?id=$pid");
			}
		}
		
		else
		{
			echo "<script> alert('Sorry Field Are Empty'); </script>";
		}
	}
?>