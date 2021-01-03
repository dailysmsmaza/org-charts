<?php

	ob_end_flush();
	ob_start();
	
	include("names.php");
	include("connect.php");
	
	$id = $_GET["id"];
	$pid = $_GET["pid"];
	
	$category_id = mysqli_query($c,"select * from category_sub where cat_id=$id");
	while($category_id_data = mysqli_fetch_array($category_id))
	{
		$category_id_pid = $category_id_data["p_id"];
	}
	
?>

<html>
<head>
	<script>
		function goBack()
		{
			window.history.back();
		}
	</script>
	
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
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	
</head>
<body>

<?php
	include("header.php");
	include("chain.php");
?>
<br>
<br>
<ul class="w3-ul w3-card-4">
	
	<h5> <center> Move Category </center> </h5>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Parent ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cur_pid"  value="<?=$category_id_pid?>" style="width:60%;height:5%" disabled/>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Change Parent ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cha_pid" style="width:60%;height:5%" />
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
		$id = $_POST["id"];
		$pid = $_POST["pid"];
		
		$cha_pid = $_POST["cha_pid"];
		
		$cat_all_sms = mysqli_query($c,"select * from category where cat_id='$id'");
		while($cat_all_sms_data = mysqli_fetch_array($cat_all_sms))
		{
			$all_sms = $cat_all_sms_data["all_sms"];
		}
		
		if($cha_pid==0)
		{
			$get_all_delete_id = getParentID($id);
			foreach($get_all_delete_id as $get_p_all_delete_id)
			{
				if($get_p_all_delete_id!=0)
				{
					$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='$get_p_all_delete_id'");
				}
			}	
		}
		else
		{
			$get_all_delete_id = getParentID($id);
			foreach($get_all_delete_id as $get_p_all_delete_id)
			{
				if($get_p_all_delete_id!=0)
				{
					$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms - $all_sms where cat_id='$get_p_all_delete_id'");
				}
			}
			
			$get_all_id = getParentID($cha_pid);
			foreach($get_all_id as $get_p_all_id)
			{
				if($get_p_all_id!=0)
				{
					$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms + $all_sms where cat_id='$get_p_all_id'");
				}
			}
			$category_sms_upd = mysqli_query($c,"update category set all_sms = all_sms + $all_sms where cat_id='$cha_pid'");
		}
		
		$category_upd = mysqli_query($c,"update category_sub set p_id='$cha_pid' where cat_id='$id'");
		$category_upd = mysqli_query($c,"update category set p_id='$cha_pid' where cat_id='$id'");
		
		header("location:$adminurl/home.php?id=$pid");
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
