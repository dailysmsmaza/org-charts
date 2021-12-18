<?php

	ob_end_flush();
	ob_start();
	
if(isset($_GET["id"]))
{
		$id = $_GET["id"];
	
		include("names.php");
		require("connect.php");	

		mysqli_query($c,"SET NAMES 'utf8'"); 
		mysqli_set_charset($c,"utf8");
	
?>

<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>	
	
	<title> Add Category Here :: <?=$title?> : Admin Panel </title>

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
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	
	<script>
		$(document).ready(function() 
		{
			var desc_max = 160;
			var title_max = 60;
			
			$('#description_count').html(desc_max + ' characters');

			$('#textarea').keyup(function() {
				var desc_length = $('#textarea').val().length;
				var text_remaining = desc_max - desc_length;

				$('#description_count').html(desc_remaining + ' characters');
			});
			
			
			$('#title_count').html(title_max + ' characters');

			$('#title').keyup(function() {
				var title_length = $('#title').val().length;
				var title_remaining = title_max - title_length;

				$('#title_count').html(title_remaining + ' characters');
			});
			
		});
	</script>
	
</head>

<?php

?>

<body>
	<?php 
			include("header.php");			
	?>

<ul class="w3-ul w3-card-4">
	 <h4> <center> Add Category </center> </h4>
	<form class="form-horizontal" role="form" name="f1" method="post">

	<div class="container">
	
		<div>
			<label> Category Name : </label>
			<div>
				<input type="text" name="cat_name" style="width:60%;height:5%" />
			 </div>
		</div>
		
		<div>
			<label> Category Description : </label>
			<div>
				<textarea id="textarea" name="description" style="width:60%;height:30%" maxlength="160" ></textarea>
				<span id="description_count"></span>
			 </div>
			 
		</div>

		<div>
			<label> Category Title : </label>
			<div>
				<input type="text" id="title" name="title" style="width:60%;height:5%" maxlength="60"/>
				<span id="title_count"></span>
			 </div>
		</div>
		
		<br>
		<div>
			<label> Status : </label>
			<div>
				<input type="radio" name="r" value="Active" checked="checked"> Active
				<input type="radio" name="r" value="Deactive"> Deactive &nbsp;&nbsp;
			</div>
		</div>
		
		<br>
		<div>
			<label> Flag : </label>
			<div>
				<input type="checkbox" name="new" value="1"><span style="text-align:left;margin-left:0px;"> New</span> &nbsp;&nbsp;
				<input type="checkbox" name="updated" value="1"><span style="text-align:left;margin-left:0px;"> Updated</span> &nbsp;&nbsp;    
			</div>
		</div>
		
		<br>
		<div style="margin-left:10px">
			<input type="hidden" name="pid" value="<?=$id?>">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
		</div>
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
			$pid = $_POST["pid"];
			
			$status = $_POST["r"];
			$cat_name = mysqli_real_escape_string($c,$_POST["cat_name"]);
			$cat_name = trim(ucwords($cat_name));
			
			$cat_chk = mysqli_query($c,"select * from category where cat_name='$cat_name'");
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
						
				
				if(empty($cat_title))
				{
					$cat_title = $cat_name;
				}
						
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
				
				$category_insert = mysqli_query($c,"insert into category(cat_name,cat_title,cat_description,status,new,updated,p_id)values('$cat_name','$cat_title','$description','$status','$new','$updated','$pid')");
				if (mysqli_query($c,$category_insert));
				{
					$last_id = mysqli_insert_id($c);
					$category_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,cat_order,p_id) values ('$last_id','$cat_name','$last_id','$pid') ");	
				}
				
				header("location:$adminurl/home.php?id=$id");
			}
		
		}
		else
		{
			echo "Sorry Field Are Empty";
		}	
}
?>

<?php
}
?>