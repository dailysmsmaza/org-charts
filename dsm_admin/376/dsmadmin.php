<?php
	
	require("connect.php");
	include("names.php");
	
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		if(!empty($username) && !empty($password))
		{
			$q = mysqli_query($c,"select id from admin where username='$username' and password='$password'");
			$n = mysqli_num_rows($q);
	
			if($n==0)
			{
				// echo "login";
				header("location:$url");
			}
			else
			{
				session_start();
				$_SESSION['username']=$username;
				header("location:$adminurl/home.php?id=0&limit=all");
				exit();
			}
		}
		else
		{
			echo "<center> <h2> plz enter username/password </h2> </center>";
		}
	}
	
	
	

?>


<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title> Login :: <?=$title?> : Admin Panel </title>
</head>
<body>
	<div class="top">
		<div class="logo">
		<div class="left"> <?=$title?> Admin Panel </div>
		 <span style="font-size:14px"> Developed By : Sahil Hamirani  </span>
	</div>
	</div>
	<div class="end"> </div>
	<div class="loginbox roundcorner">
		<div class="log_title roundcorner"> <strong> Admin Login </strong> </div>
			<form method="post">
				<span style="font-size:18px"> <i> Username: </i> </span>
				<input type="text" class="txtbox roundcorner" name="username"> 
				<br> <br>
				<span style="font-size:18px"> <i> Password: </i> </span>
				<input type="password" class="txtbox roundcorner" name="password">
				<br> <br>
				<input type="submit" value="Login">
			</form>
	</div>
</body>
</html>