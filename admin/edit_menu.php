<?php
	ob_end_flush();
	ob_start();

	include("names.php");
	include("header.php");
	include("connect.php");
	
	$id = $_GET["id"];
	
	$default_id = mysqli_query($c,"select * from default_id where id=$id");
	while($default_id_data = mysqli_fetch_array($default_id))
	{
		$default_id_name = $default_id_data["name"];
		$default_id_pid = $default_id_data["pid"];
	}
	
	
?>	

<html>
<head>
		<script type="text/javascript">
			function goback()
			{
				window.history.back();
			}
		</script>
</head>
<body>

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Default Menu Item Edit </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="name" value="<?=$default_id_name?>" disabled/>
			 </div>
		</div>
					
				
		<div class="form-group">
			<label class="col-sm-10"> Default : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="pid" value="<?=$default_id_pid?>"/>
			 </div>
		</div>
		

		<br>
		
		<div class="form-group" style="margin-left:10px">
			<input type="hidden" name="id" value="<?=$id?>">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
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
			$p_id = $_POST["pid"];
			$id = $_POST["id"];
			$default_update = mysqli_query($c,"update default_id set pid='$p_id' where id=$id");
			header("location:$adminurl/default_menu.php");
	}
	
?>