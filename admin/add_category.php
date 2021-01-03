<?php

	ob_end_flush();
	ob_start();
	
if(isset($_GET["id"]))
{
		$id = $_GET["id"];
	
		include("names.php");
		require("connect.php");	
		include("header.php");

		mysqli_query($c,"SET NAMES 'utf8'"); 
		mysqli_set_charset($c,"utf8");
	
?>

<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>	
	
	<title> Add Category :: <?=$title?> : Admin Panel </title>

	
</head>

<?php

?>

<body>

<?php
	include("chain.php");
?>
 

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Add Category </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Category Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cat_name" />
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Category Description : </label>
			<div class="col-sm-7">
				<textarea class="form-control" rows="3" name="description"></textarea>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Category Title : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="title" />
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Status : </label>
			<div class="col-sm-7">
				<input type="radio" name="r" value="Active" checked="checked"> Active
				<input type="radio" name="r" value="Deactive"> Deactive &nbsp;&nbsp;
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Flag : </label>
			<div class="col-sm-7">
				<input type="checkbox" name="new" value="1"><span style="text-align:left;margin-left:0px;"> New</span> &nbsp;&nbsp;
				<input type="checkbox" name="updated" value="1"><span style="text-align:left;margin-left:0px;"> Updated</span> &nbsp;&nbsp;    
			</div>
		</div>
		<br>
		<div class="form-group" style="margin-left:10px">
			<input type="hidden" name="pid" value="<?=$id?>">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
		</div>
		
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