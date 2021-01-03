<?php
	
	ob_end_flush();
	ob_start();

	include("names.php");
	
	include("header.php");		
	include("connect.php");
	
	$id = $_GET["id"];
	$pid = $_GET["pid"];	
	
	$category = mysqli_query($c,"select * from category where cat_id=$id");
	while($category_data = mysqli_fetch_array($category))
	{
		$cat_pid = $category_data["p_id"];
		$cat_name = $category_data["cat_name"];
	}
	
	$category_sub = mysqli_query($c,"select * from category_sub where cat_id=$id AND p_id!=$cat_pid");
	$category_sub_count = mysqli_num_rows($category_sub);
	if($category_sub_count>=1)
	{
		while($category_sub_data = mysqli_fetch_array($category_sub))
		{
			$category_sub_pid = $category_sub_data["p_id"];
			$category_sub_pid_all[] = $category_sub_pid;
			$category = mysqli_query($c,"select * from category where cat_id=$category_sub_pid");
			while($category_data = mysqli_fetch_array($category))
			{
				$cat_sub_name[] = $category_data["cat_name"];
			}
		}
		$category_sub_pid_imp = implode(",",$category_sub_pid_all);
		$category_sub_name_imp = implode(",",$cat_sub_name);
	}
	
		include("chain.php");
?>		
		
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
<title> Add Parent :: <?=$title?> : Admin Panel </title>

</head>
<body>

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Add Parent </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Parent ID : </label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="avail_pid" value="<?=$cat_pid?>" disabled />
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="avail_pname" size="30" value="<?=$cat_name?>" disabled />
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Add Parent ID : </label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="add_pid" value="<?php if(!empty($category_sub_pid_imp)) echo $category_sub_pid_imp.","; ?>">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="add_pname" placeholder="Optional" value="<?php if(!empty($category_sub_name_imp)) echo $category_sub_name_imp.","; ?>">
			 </div>
		</div>
		
		<br>
		
		<div class="form-group" style="margin-left:10px">
			 <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
		</div>
		
	</div>
	
	</form>
	
</ul>

	
<?php		

		if(isset($_POST["submit"]))
		{
			$id = $_POST["id"];
			$pid = $_POST["pid"];
			
			
			$add_pid = $_POST["add_pid"];
			if(empty($add_pid))
			{
				$delete_parent = mysqli_query($c,"delete from category_sub where cat_id=$id AND p_id!=$cat_pid");
				header("location:$adminurl/home.php?id=$pid");
			}
			else
			{
				$add_pid_exp = explode(",",$add_pid);
				
				$delete_parent = mysqli_query($c,"delete from category_sub where cat_id=$id AND p_id!=$cat_pid");
				
				foreach($add_pid_exp as $all_pid)
				{
				
					$category = mysqli_query($c,"select * from category where cat_id='$all_pid'");
					$category_count = mysqli_num_rows($category);
					
					if($category_count>=1)
					{
						while($category_data = mysqli_fetch_array($category))
						{
							$category_name = $category_data["cat_name"];
							$category_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,p_id) values ('$id','$category_name','$all_pid')");
						}
						header("location:$adminurl/home.php?id=$pid");
					}
					else
					{
						echo "<script> alert('This Category ID Is Not Available..') </script>";
					}
				}
				
			}
		}
	
?>