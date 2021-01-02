<?php
	ob_end_flush();
	ob_start();
	
	include("names.php");
	include("header.php");
	
if(empty($_SESSION[$s_name]))
{
		header("location:$url/");
}
else
{		
	require("connect.php");	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="language" content="english" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="<?=$url?>/style.css" />
		
  
		<title> Add Sms :: <?=$title?> </title>
        
        <script type="text/javascript">
			function goback()
			{
				window.history.back();
			}
		</script>
        
</head>
<body>

<?php
	include("category_menu_pc.php");
?>

	<div class="col-sm-6">

            <ul class="w3-ul w3-card-4">
              <li class="w3-cyan"> <center> Add SMS </center> </li>
           </ul>


<?php
	if(isset($_GET["msg"]))
		{
			$msg = $_GET["msg"];
			if($msg=="confirm")
			{
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Saved!</strong> Your SMS , Please Wait Some Time It Can Be Add After Admin Confirm. ';
				echo "</div>";
				
			}
		}
?>

<ul class="w3-ul w3-card-4">
	
	<form class="form-horizontal" role="form" name="f1" method="post">

	<div class="form-group">
	</div>

	<div class="form-group container">
		<label class="col-sm-10"> SMS : </label>
		<div class="col-sm-7">
			<textarea class="form-control" rows="3" id="comment" name="sms"></textarea>
		 </div>
	</div>

	<div class="form-group container">
		<label class="col-sm-10"> Category : </label>
		<div class="col-sm-7">
			<select name="cat_name" class="form-control">
			<?php
			
				$category = mysqli_query($c,"select c.cat_id,c.cat_name from category c INNER JOIN message_sub m where m.id=c.cat_id");
				 while($category_data = mysqli_fetch_array($category))
				 {
					$cat_name = $category_data[1];
			?>
					<option value="<?php echo $cat_name; ?> "> <?php echo $cat_name; ?>  </option>
			 <?php
				 } 
				 
				 
			?>
			</select>
		 </div>
	</div>
		   
	</select>

	<div align="center">
		<input class="btn btn-success" type="submit" value="Save" />
		<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
	</div>
	
	</form>
	<br>
</ul>

</div>
</body>
</html>

<?php	
	if(!empty($_POST["sms"]) && !empty($_POST["cat_name"]) && !empty($_SESSION[$s_name]))
	{
		
		$sms = $_POST["sms"];
		$cat_name = $_POST["cat_name"];
		
		$category_id_query = mysqli_query($c,"select * from category where cat_name='$cat_name'");
		while($category_id_data = mysqli_fetch_array($category_id_query))
		{
			
			$category_id_id = $category_id_data["cat_id"];
			
			$user_id = $_SESSION[$s_id];
			$date = strtotime("now");
		
			$q = mysqli_query($c,"insert into user_message(sms,cat_id,date,user_id)values('$sms','$category_id_id','$date','$user_id')");
    
			header("location:$url//addsms/confirm");
		
	   	}
	}

}
?>