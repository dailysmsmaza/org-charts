<?php
	ob_end_flush();
	ob_start();
	
	include("names.php");
	include("header.php");
	include("connect.php");
	
	$id = $_GET["id"];
	$pid = $_GET["pid"];
	
	$category_id = mysqli_query($c,"select * from category_sub where cat_id=$id");
	while($category_id_data = mysqli_fetch_array($category_id))
	{
		$category_id_pid = $category_id_data["p_id"];
	}
	
	include("chain.php");
	
?>

<html>
<head>
	<script>
		function goBack()
		{
			window.history.back();
		}
	</script>
</head>
<body>

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Move Category </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Parent ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cur_pid"  value="<?=$category_id_pid?>" disabled/>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Change Parent ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="cha_pid"/>
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

</body>
</html>


		
<?php
	if(isset($_POST["submit"]))
	{
		$id = $_POST["id"];
		$pid = $_POST["pid"];
		
		$cha_pid = $_POST["cha_pid"];
		$category_upd = mysqli_query($c,"update category_sub set p_id='$cha_pid' where cat_id='$id'");
		$category_upd = mysqli_query($c,"update category set p_id='$cha_pid' where cat_id='$id'");
		header("location:$adminurl/home.php?id=$pid");
	}	
?>
