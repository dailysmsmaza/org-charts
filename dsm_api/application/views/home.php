<?php

	
	//include_once("names.php");
?>

<!DOCTYPE html>
<html>
<head>
  
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	

    <link rel="stylesheet" href="<?php echo base_url('css/w3.css');?>">
    <link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	
	
	
</head>

<body>
	
    	<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                        <a href="<?php echo base_url(); ?>" class="navbar-brand"><span class="glyphicon glyphicon-home"> </span> &nbsp; <?php echo SITE_TITLE; ?> </a>
                </div>   
                <div>  
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
						<li> <a href="<?php echo base_url(); ?>disclaimerisc"><span class="glyphicon glyphicon-book"></span> Disclaimer </a> </li>
						<li> <a href="mailto:dailysmsmaza@gmail.com"><span class="glyphicon glyphicon-book"></span> Contact Us </a> </li>
                    </ul>
                 </div>
                </div>
         </div>      
        </div>
        </nav>
    

	<div class="container">
		<form class="navbar-form navbar-right" method="POST">
		   <div class="input-group">
			   <input type="text" name="search" placeholder="Search..." class="form-control" />
			   <div class="input-group-btn">
				   <button class="btn btn-info">
				   <span class="glyphicon glyphicon-search"></span>
				   </button>
			   </div>
		   </div>
		</form>
	</div>


    <div class="container visible-lg visible-md">
		<nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
                <li> <a href="<?php echo base_url(); ?>/last/updated/sms/new2old/page/1" class="list-group-item"> Last / Latest Updated Sms </a> </li>
                <li> <a href="<?php echo base_url(); ?>/popular/most/sms/new2old/page/1" class="list-group-item"> Popular Sms </a> </li>
                <li> <a href="<?php echo base_url(); ?>/top/user/page/1" class="list-group-item"> Top User </a> </li>
             </ul>             
    	</nav>
    </div>

	
	<?php
		if(isset($_POST["search"]))
		{
			$search = $_POST["search"];
			header("location:$url/search/$search/page/1");
		}
	?>
    
</body>
</html>
