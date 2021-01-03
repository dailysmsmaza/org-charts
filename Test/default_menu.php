<?php

	include("names.php");
	
	require("connect.php");
	
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/w3.css" rel="stylesheet">
	<style>
		body { padding-top: 60px; }
		table { width: 100%; }
		td, th {text-align: left;	word-wrap: break-word;}
		h2, h3 {margin-top: 1em;}
		section {padding-top: 40px;}
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="assets/css/no-more-tables.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script type="text/javascript">
		
		function edit_menu(id)
		{
			window.location = "edit_menu.php?id="+id;
		}
	</script>
	
  </head>

  <body>

    <?php 
			include("header.php");			
	?>
	
<div class="w3-panel w3-card-4">    
	<strong> Default Menu | </strong>
</div>

    <div class="container-fluid">
     
	  <section id="no-more-tables">
			
		  <table class="table-bordered table-striped table-condensed cf">
			  <thead class="cf">
				  <tr>
						<th>ID</th>
        				<th>Name</th>
        				<th>Default</th>
        				<th>Action</th>
				  </tr>
			  </thead>
				<tbody>
				
					<?php
						$default = mysqli_query($c,"select * from default_id");
						 while($default_data = mysqli_fetch_array($default))
						 {
							 $default_id = $default_data["id"];
							 $default_name = $default_data["name"];
							 $default_pid = $default_data["pid"];
					?>

					<tr>
						<td data-title="ID" style="word-wrap: break-word;"><?php echo $default_id; ?></td>
						<td data-title="Name" style="word-wrap: break-word;">
								<span class="w3-text-blue"> <?php echo $default_name; ?> </span>							
						</td>
						
						<td data-title="Default" style="word-wrap: break-word;">	<?php echo $default_pid; ?>	</td>
						
						<td data-title="Action"> 		
								<img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action" onClick="edit_menu(<?=$default_id?>)"/> 
						</td>
					</tr>
					<?php
						}
					 ?>	 
				</tbody>
		  </table>
		  
	  </section>
    </div> <!-- /container -->

    <script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/prettify.js"></script>
	<script>
		$(function(){
			prettyPrint();
		});
	</script>
  </body>
</html>
