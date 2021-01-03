<?php
	
	ob_end_flush();
	ob_start();

	include("names.php");
	
	include("connect.php");
	
	$id = $_GET["id"];
	$pid = $_GET["pid"];	
	
	$category = mysqli_query($c,"select * from category where cat_id='".$id."'");
	while($category_data = mysqli_fetch_array($category))
	{
		$cat_pid = $category_data["p_id"];
		$cat_name = $category_data["cat_name"];
		$all_sms = $category_data["all_sms"];
	}
	
	$category_sub = mysqli_query($c,"select * from category_sub where cat_id='".$id."' AND p_id!='".$cat_pid."' ");
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
	
		
?>		
		
<html>
<head>

	<title> Add Parent :: <?php echo $title; ?> : Admin Panel </title>

	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>	
	
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
	
</head>
<body>

<?php
	include("chain.php");
	include("header.php");		
?>

<ul class="w3-ul w3-card-4">

	<h3> <center> Add Parent </center> </h3>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Parent ID : </label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="avail_pid" style="width:60%;height:5%" value="<?=$cat_pid?>" disabled />
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="avail_pname" size="30" style="width:60%;height:5%" value="<?=$cat_name?>" disabled />
			 </div>
		</div>
		
		<br>
		
		<div class="form-group">
			<label class="col-sm-10"> Add Parent ID : </label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="add_pid" style="width:60%;height:5%" value="<?php if(!empty($category_sub_pid_imp)) echo $category_sub_pid_imp.","; ?>">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="add_pname" style="width:60%;height:5%" placeholder="Optional" value="<?php if(!empty($category_sub_name_imp)) echo $category_sub_name_imp.","; ?>">
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
	
	<br>
	
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
				$delete_parent_get = mysqli_query($c,"select * from category_sub where cat_id='".$id."' AND p_id!='".$cat_pid."'");
				$delete_parent_get_count = mysqli_num_rows($delete_parent_get);
				
				if($delete_parent_get_count>0)
				{
					while($delete_parent_get_data = mysqli_fetch_array($delete_parent_get))
					{
						$delete_parent_get_data_id = $delete_parent_get_data["p_id"];
						
						$get_all_delete_id = getParentID($delete_parent_get_data_id);
						foreach($get_all_delete_id as $get_p_all_delete_id)
						{
							if($get_p_all_delete_id!=0)
							{
								$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$get_p_all_delete_id."'");
							}
						}

						$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$delete_parent_get_data_id."'");
					}
					
					$delete_parent = mysqli_query($c,"delete from category_sub where cat_id='".$id."' AND p_id!='".$cat_pid."'");
					header("location:$adminurl/home.php?id=$pid");
				}
			}
			else
			{
				$add_pid_exp = explode(",",$add_pid);
				
				$delete_parent_get = mysqli_query($c,"select * from category_sub where cat_id='".$id."' AND p_id!='".$cat_pid."'");
				$delete_parent_get_count = mysqli_num_rows($delete_parent_get);
				
				if($delete_parent_get_count>0)
				{
					while($delete_parent_get_data = mysqli_fetch_array($delete_parent_get))
					{
						$delete_parent_get_data_id = $delete_parent_get_data["p_id"];
						
						$get_all_delete_id = getParentID($delete_parent_get_data_id);
						foreach($get_all_delete_id as $get_p_all_delete_id)
						{
							if($get_p_all_delete_id!=0)
							{
								$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$get_p_all_delete_id."'");
							}
						}

						$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='".$delete_parent_get_data_id."'");
					}
				
					$delete_parent = mysqli_query($c,"delete from category_sub where cat_id='".$id."' AND p_id!='".$cat_pid."'");
				}
				
				foreach($add_pid_exp as $all_pid)
				{
				
					$category = mysqli_query($c,"select * from category where cat_id='".$all_pid."'");
					$category_count = mysqli_num_rows($category);
					
					if($category_count>=1)
					{
						while($category_data = mysqli_fetch_array($category))
						{
							$category_name = $category_data["cat_name"];
							
							$get_all_id = getParentID($all_pid);
							foreach($get_all_id as $get_p_all_id)
							{
								if($get_p_all_id!=0)
								{
									$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms + $all_sms where cat_id='".$get_p_all_id."'");
								}
							}
							
							$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms + $all_sms where cat_id='".$all_pid."'");
							
							$category_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,p_id) values ('$id','$category_name','$all_pid')");
						}
						
					}
					else
					{
						echo "<script> alert('This Category ID Is Not Available..') </script>";
					}
				}
				header("location:$adminurl/home.php?id=$pid");
			}
		}
	
	
		function getParentID($c_id)
		{	

			global $c;
			global $adminhome;
			global $adminurl;

			$cat_sub_id = mysqli_query($c,"select * from category where cat_id='$c_id'");
			while($cat_sub_id_data = mysqli_fetch_array($cat_sub_id))
			{
				$cat_sub_pid = $cat_sub_id_data["p_id"];
				$cat_sub_p_id[] = $cat_sub_pid;
				getParentID($cat_sub_pid);
			}
			if(isset($cat_sub_p_id))
			{
				return $cat_sub_p_id;
			}
		}
		
?>