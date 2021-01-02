<?php

	ob_end_flush();
	ob_start();
	
	include("header.php");
	include("names.php");
			
	if(isset($_SESSION[$s_name]))
	{
		
		require("connect.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="language" content="english" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="<?=$url?>/style.css">

<link rel="stylesheet" href="<?=$url?>/bootstrap/bootstrap.min.css">
<script src="<?=$url?>/bootstrap/jquery.min.js"></script>
<script src="<?=$url?>/bootstrap/bootstrap.min.js"></script>
  
	
	<title> Change Password </title>
    
</head>
<body>

<?php
	include("category_menu_pc.php");
?>

	    <div class="col-sm-6">
            
            <ul class="w3-ul w3-card-4">
              <li class="w3-cyan"> <center> Change Password </center> </li>
           </ul>
                
	<?php
	
		if(isset($_GET["msg"]))
		{
			$msg=$_GET["msg"];
			if($msg=="nochange")
			{
		
			?>
            
				<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Sorry !</strong> Password Does Not Match.
				</div>
            
            <?php
			
			}
		}
	?>


<form method="post" class="form-horizontal" role="form">

<div class="form-group">
</div>
<div class="form-group">
</div>

<div class="form-group">
	<label class="col-sm-2"> Old Password </label>
 	<div class="col-sm-10">
		<input class="form-control" id="focusedInput" type="password" name="oldpassword">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2"> New Password </label>
	<div class="col-sm-10">
		<input class="form-control" id="focusedInput" type="password" name="newpassword">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2"> Conform Password </label>
	<div class="col-sm-10">
		<input class="form-control" id="focusedInput" type="password" name="passwordagain">
	</div>
</div>
				
	<input class="btn btn-success" type="submit" value="send"> 
	<input class="btn btn-warning" type="button" value="cancel" onClick="window.history.back();">
		
		
	</form>

	
</body>
</html>

<?php

	
		
	
	
	if(!empty($_SESSION[$s_name]) && !empty($_POST["oldpassword"]) && !empty($_POST["newpassword"]) && !empty($_POST["passwordagain"]))	
	{
			
		$username=$_SESSION[$s_name];
		$old = $_POST["oldpassword"];
		$new = $_POST["newpassword"];
		$again=$_POST["passwordagain"];
		
			$q=mysqli_query($c,"select * from user where username='$username' AND password='$old' OR email='$username'");
	
			if($new!=$again)
			{
				//header('location:$url/password/nochange');
				?>
                	<script>
						window.location = "<?=$url?>/password/nochange";
					</script>
                <?php
			}
			else
			{
				$in = mysqli_query($c,"update user set password='$new' where username='$username'");
				?>
                <script type="text/javascript">
					window.location = "<?php echo $url; ?>/account/password";
				</script>
                <?php
			}
		}
	
	
?>


<?php

	}
	else
	{
		header("location:$url/");
	}
?>