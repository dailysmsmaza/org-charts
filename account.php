<?php

	ob_end_flush();
	ob_start();
	
	include("names.php");
	include("header.php");
	
if(isset($_SESSION[$s_name]))
{
	require("connect.php");
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<title> User Account </title>
    
</head>

<body>

<?php 

	include("category_menu_pc.php");

	
			$username = $_SESSION[$s_name];
			$user_id = $_SESSION[$s_id];
			
			$user = mysqli_query($c,"select * from user where user_id='$user_id'");
			while($user_data=mysqli_fetch_array($user))
			{	
				$user_email = $user_data['email'];
				$user_name = $user_data['username'];
			}
		?>
        
    <div class="col-sm-6">
    
            <ul class="w3-ul w3-card-4">
              <li class="w3-cyan"> <center> Edit Profile </center> </li>
           </ul>
            


<?php

  	 if(isset($_GET["msg"]))
		{
			$msg=$_GET["msg"];
			
			if($msg=="password")
			{
				?>
				<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Password!</strong> Has Been Changed.'
				</div>
				<?php
			}
		}
		if(isset($_GET["msg"]))
		{
			$msg=$_GET["msg"];
			if($msg=="uname")
			{
				?>
				<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Username!</strong> Has Been Changed.'
				</div>
				<?php
			}
		}

?>

<form method='post' class="form-horizontal" role="form">
<div class="form-group">
</div>
<div class="form-group">
</div>
<div class="form-group">
	<label class="col-sm-3 control-label"> E-Mail : </label>
	<div class="col-sm-8">
		<input class="form-control" id="disabledInput" type="text" value="<?=$user_email?>" disabled/>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label"> Username : </label>
	<div class="col-sm-8">
		<input class="form-control" id="focusedInput" type="text" value="<?=$user_name?>" name="username_change"/>
	</div>
</div>

<center>
<input type="submit" class="btn btn-success" value="Save">
<button type="button" class='btn btn-warning' onclick='window.history.back()'> Back </button> <br /> <br />
<button type="button" class="btn btn-info" onclick="window.location='<?=$url?>/password/change'"> Change Password </button>
</center>

</form>
</div>
<?php

	if(isset($_POST['username_change']))
	{
		
		echo "<a href='$url/password/change'> [Change Password] </a>";
		
		$username_change = $_POST['username_change'];
		
		$user_update = mysqli_query($c,"update user set username='$username_change' where username='$username'");
		
		unset($_SESSION["username"]);
		session_destroy();
		session_start();
		$_SESSION[$s_name]=$user;
		
		?>
		<script type="text/javascript">
            window.location = "<?php echo $url; ?>/account/uname";
        </script>
        <?php
	}
	
?>

<?php
	//this code is used for message and user_message table username are changed at username are change
	if(isset($_POST['username_change']))
	{
		$msg_id_change = mysqli_query($c,"update message set username='$username_change' where username='$username'");
		$user_msg_id_change = mysqli_query($c,"update user_message set username='$username_change' where username='$username'");
	}
	

	
?>


</body>
</html>

<?php
	
}
else
{
	header("location:$url/");
}
?>