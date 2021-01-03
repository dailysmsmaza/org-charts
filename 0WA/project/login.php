<!DOCTYPE html>
<html lang="en">
<head>
  <title>login page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="C:/Users/God/Desktop/1111/css/w3.css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script src="https://kit.fontawesome.com/8c436cae97.js"></script>
</head>
<body bgcolor="black">

<!--<div class="container text-center">
  <h1><b>Login</b> Screen</h1>
</div>-->



<div class="container h-100 ">
<div class="jumbotron min-vh-100 text-left m-0 d-flex flex-column justify-content-center">
  	<div class="row h-100 justify-content-center align-items-center">
  			<div class="col-md-6">
    				<div class="row-lg-7">
    				<center><h1><b>Login</b> Screen</h1></center><br>
    				<br>
    					<form id="defaultForm" method="post" class="form-horizontal w3-container w3-card-4">

    					<form id="defaultForm" method="post" class="form-horizontal w3-container w3-card-4">
      					
      					<div class="form-group col-lg-9"><br>
        					<label for="formGroupExampleInput" class="control-label">Username*</label>
        						<div class="input-group">
      									<input type="text" name="usename" class="form-control border-right-0" aria-label="from" aria-describedby="from">
      										<div class="input-group-append">
        									<span class="input-group-text bg-transparent"><i class="far fa-envelope"></i></span>
      										</div>
								</div>		
      					</div>


      					<div class="form-group col-lg-9">
        					<label for="formGroupExampleInput2">Password*</label>
        						<div class="input-group">
      									<input type="password" name="password" class="form-control border-right-0" aria-label="from" aria-describedby="from">	
                                		<div class="input-group-append">
                                		<span class="input-group-text bg-transparent"><i class="fas fa-lock">
                                		</i></span>
                                		</div>
                               </div>    	
     					 </div>

     					
     					 <div class="form-group col-lg-4">
                            <button type="submit" class="btn btn-info" name="submit" value="Sign in ">Sign in
                            </button>
                         </div>
                         <br>
    					</form>
    					</form>
    				</div>
    		</div>   
  	</div>  
</div>
</div>
     

</body>
</html>







 /*
$con=mysqli_connect("localhost","root", " ", "demo");

if(!$con){
	echo " connection error"; . mysqli_connect_error();
}

if(isset($_POST['sumbit']))
{
	$user_nm=$_POST['username'];
	$pwd=$_POST['password'];


	$query=mysqli_query("insert into login(u_name,u_pass) values('$user_nm', '$pwd')");

if($query)
{
	echo "login Successfully";
}
else{
	echo "plz enter valid username & password";
}
}

?>  */






