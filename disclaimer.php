<?php
	
	include("connect.php");
	include("header.php");
	include("names.php");

?>

<!DOCTYPE html>
<html>
<head>

   <meta charset="utf-8">
   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/w3.css">
    <link href="style.css" rel="stylesheet">
    
    <title>  Disclaimer :: www.DailySmsMaza.com  </title>


</head>

<body id="top">

	<?php include_once("analyticstracking.php"); ?>
       
	   <?php include_once("category_menu_pc.php"); ?>
    
    	<div class="col-sm-6">
        
           <ul class="w3-ul w3-card-4">
              <li class="w3-cyan"> <center> Disclaimer </center> </li>
           </ul>
           
            
            <div class="list-group">
            	<ul class="w3-ul w3-card-4">
				
            			<?php

							$disclaimer = mysqli_query($c,"select * from disclaimer order by id");
							while($disclaimer_data = mysqli_fetch_array($disclaimer))
							{
								$disclaimer_desc = $disclaimer_data["description"];
								
						?>
                         <li> 
							<a class="list-group-item">
								<span class="glyphicon glyphicon-hand-right"> </span> &nbsp; 
								<?php echo $disclaimer_desc; ?>
							</a> 
						</li>
						
                        <?php
							}
						?>
						
                 </ul>
            </div>
        </div>   
	
		<?php include_once("Back_&_Bottom_to_Top_Jquery.php"); ?>
	
</body>
</html>