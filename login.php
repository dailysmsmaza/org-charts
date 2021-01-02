<?php
	ob_end_flush();
	ob_start();
	
	include("header.php");
	require("connect.php");
	include("names.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">  
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrapValidator.css"/>
	
	<title> Login :: <?php echo $title; ?> </title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="robots" content="index,follow">
	<meta name="title" content="Login :: <?php echo $title; ?>">
	<meta name="keywords" content="Login, After Registration, user site, everyone upload sms, free upload or sharing sms after login  :: <?php echo $title; ?>">
	<meta name="description" content="Login everyone can share it's own sms to people can like or share their sms :: <?php echo $title; ?>">  
    

</head>
<body>

<?php include_once("analyticstracking.php"); ?>

<?php
	include("category_menu_pc.php");
?>
	<div class="col-sm-6">
    
    	<ul class="w3-ul w3-card-4">
        	<li class="w3-cyan"> <center> Login </center> </li>
        </ul>
        
       	<form id="defaultForm" method="post" class="form-horizontal w3-container w3-card-4">
        
        	<div class="w3-group">
            </div>
            
             <?php
				if(isset($_GET["msg"]))
				{
					$msg = $_GET["msg"];
					
					if($msg=="wrong")
					{
					?>
					
					<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Username & password</strong> Does Not Match..!
					</div>
					
					<?php
					}
				}
			?>      
                    <form id="defaultForm" method="post" class="form-horizontal w3-container w3-card-4">
					
					<br>
					
					<?php
						if(isset($_GET["msg"]))
						{
							$msg = $_GET["msg"];
							if($msg=="u")
							{	
								echo '<div class="alert alert-danger">';
								echo '<center><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Username !</strong> are already exists.</center>';
								echo "</div>";
							}
							if($msg=="ea")
							{
								echo '<div class="alert alert-danger">';
								echo '<center><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>E-Mail !</strong> address already Exists.</center>';
								echo "</div>";
									
							}
						}
					?>      
					
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="username" />
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>
						
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="w3-btn w3-teal" name="submit" value="Log In">Log In</button>
                            </div>
                        </div>
						
                    </form>

</body>
</html>

<?php
		
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$username = $_POST["username"];
			$password = $_POST["password"];
			
			
				$user = mysqli_query($c,"select * from user where username='$username' AND password='$password' OR email='$username'");
				
				$user_count =  mysqli_num_rows($user);
				
				
				if($user_count==1)
				{		
						$user_data = mysqli_fetch_row($user);
						$user_id = $user_data[0];
						
						$_SESSION[$s_name] = $username;
						$_SESSION[$s_id] = $user_id;
				
						mysqli_close($c);
						header("location:$url");
				}
				else
				{
					mysqli_close($c);
					header("location:$url/login/wrong");
				}

			
		}
	
?>