<?php	
	ob_end_flush();
	ob_start();
	
	include("header.php");
	require("connect.php");
	include("names.php");
	
?>


<!DOCTYPE html>
<html>
<head>
   <base href="/">
   
	<title> Sign Up :: <?=$title?> </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrapValidator.css"/>
	
	<link href="style.css" rel="stylesheet">
	
    <script type="text/javascript" src="<?php echo $url; ?>/bootstrap/jquery-1.10.2.min.js"></script>

    <script type="text/javascript" src="<?php echo $url; ?>/bootstrap/bootstrapValidator.js"></script>
	
	
  
</head>
<body>

<?php include_once("analyticstracking.php"); ?>

<?php
	include("category_menu_pc.php");
?>

	<div class="col-sm-6">
    
    	<ul class="w3-ul w3-card-4">
        	<li class="w3-cyan"> <center> Register </center> </li>
        </ul>
		
		
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
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="email" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Retype password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="confirmPassword" />
                            </div>
                        </div>

                       
                        <div class="form-group">
                            <label class="col-lg-3 control-label" id="captchaOperation"></label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="captcha" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="w3-btn w3-teal" name="signup" value="Sign up">Sign up</button>
                            </div>
                        </div>
                    </form>
    </div>
	<br>
	<div class="col-sm-3">
	</div>
<script type="text/javascript">
$(document).ready(function() {

    // Generate a simple captcha
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

    $('#defaultForm').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    },
                    different: {
                        field: 'password,confirmPassword',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Wrong answer',
                        callback: function(value, validator) {
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            }
        }
    });

    // Validate the form manually
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');
    });

    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
});
</script>
</body>
</html>

<?php
		
	if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]))
	{
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		//$password_hash = md5("$password");
		
		
		$check_unm = mysqli_query($c,"select username from user where username='$username'");
				
		$check_mail = mysqli_query($c,"select email from user where email='$email'");
				
		if(mysqli_num_rows($check_unm)==1)
		{
			header("location:$url/register/u");
		}
		else if(mysqli_num_rows($check_mail)==1)
		{
			header("location:$url/register/ea");
		}		
		else
		{
			$query=mysqli_query($c,"insert into user(username,email,password)values('$username','$email','$password')");	
							
			$_SESSION[$s_name]=$username;
			
			$user = mysqli_query($c,"select * from user where username='$username' ");
			while($user_data = mysqli_fetch_array($user))
			{
				$_SESSION[$s_id]=$user_data["user_id"];
			}
			header("location:$url");		
		}	
			
	}
?>