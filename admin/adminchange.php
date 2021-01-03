<?php
	ob_end_flush();
	ob_start();

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

<style>
.wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
}

.form-signin {
  max-width: 420px;
  padding: 30px 38px 66px;
  margin: 0 auto;
  background-color: #eee;
  border: 3px dotted rgba(0,0,0,0.1);  
  }

.form-signin-heading {
  text-align:center;
  margin-bottom: 30px;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
}

input[type="text"] {
  margin-bottom: 0px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.colorgraph {
  height: 7px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
</style>

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

	<div class = "container">
		<div class="wrapper">
			<form method="post" name="Login_Form" class="form-signin">       
				<h3 class="form-signin-heading">Change Username or Password</h3>
				  <hr class="colorgraph"><br>
				  
				  <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $unm; ?>" required="" autofocus="" />
				  <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $pwd; ?>" required=""/>     		  
					<br>
				  <input class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">  			
			</form>			
		</div>
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

?>