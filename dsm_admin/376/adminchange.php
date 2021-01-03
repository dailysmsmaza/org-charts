<?php
	ob_end_flush();
	ob_start();
	session_start();
	
	if(isset($_SESSION["username"]))
	{
		include("header.php");
		include("connect.php");
		include("names.php");
		
		$username = $_SESSION["username"];
		$get_admin = mysqli_query($c,"select * from admin where username='$username'");
		while($get_admin_data = mysqli_fetch_array($get_admin))
		{
				$unm = $get_admin_data["username"];
				$pwd = $get_admin_data["password"];
		}
?>

<!doctype html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="style.css">

<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
<script src="bootstrap/jquery.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>

<title> Admin Change :: <?php echo $title; ?></title>
</head>

<body>
	
    <?php
	   if(isset($_GET["msg"]))
	   {
		if($_GET["msg"]=="success")
		{
			echo '<div class="container">';
			echo '<div class="alert alert-success">';
				
			echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><center><strong>Success !</strong>   Username & Password Has Been Changed </center>';
				
			echo "</div>";
			echo "</div>";
		}
	   }
	?>
	
	<div class="loginbox roundcorner">
    
		<div class="log_title roundcorner"> <strong> Edit Profile </strong> </div>
			<form method="post">
				<span style="font-size:18px"> <i> Username: </i> </span>
				<input type="text" class="txtbox roundcorner" name="username" value="<?php echo $unm; ?>"> 
				<br> <br>
				<span style="font-size:18px"> <i> Password: </i> </span>
				<input type="text" class="txtbox roundcorner" name="password" value="<?php echo $pwd; ?>">
				<br> <br>
				<input type="submit" value="Login" name="submit">
			</form>
	</div>

</body>
</html>

<?php
	
	if(isset($_POST["submit"]))
	{
			$user = $_POST["username"];
			$pass = $_POST["password"];
			
			$up = mysqli_query($c,"update admin set username='$user', password='$pass' where username='$unm'");
			unset($_SESSION["username"]);
			session_destroy();
			session_start();
			$_SESSION["username"]=$user;
			header("location:".$adminurl."/adminchange.php?msg=success");
	}
	
	//end session
	}
	else
	{
		header("location:$url");
	}
?>



<?php
	//include("footer.php");
?>