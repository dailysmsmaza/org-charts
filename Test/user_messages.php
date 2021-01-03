<?php

	$id = $_GET["id"];

	include("names.php");
	
	require("connect.php");
	include("counter.php");
	include('config.php');
	include('Emoji.class.php');
	
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
	
	<script src="assets/js/jquery-1.7.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/prettify.js"></script>
	<script>
		$(function(){
			prettyPrint();
		});
	</script>
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	
  </head>

  <body>

  
    <?php 
		
			include("header.php");	
			
			$user_message = mysqli_query($c,"select * from user_message");
			$user_message_count = mysqli_num_rows($user_message);
			
			if($user_message_count>=1)
			{	
	
					
	?>
	

 
    <div class="container-fluid">
      
	  <section id="no-more-tables">
			
		  <table class="table-bordered table-striped table-condensed tbl_repeat cf">
			  <thead class="cf">
				  <tr>
						<th width="5%">ID</th>
						<th width="6%">UserID</th>
						<th width="13%">UserName</th>
						<th width="50%">Message</th>
						<th width="10%">Category</th>
						<th width="8%">Time</th>
						<th width="15%">Action</th>
				  </tr>
			  </thead>
				<tbody>
				
					<?php
						while($msg_data=mysqli_fetch_array($user_message))
						{
							$user_message_id = $msg_data["id"];
							$user_message_sms = $msg_data["sms"];
							$user_message_user_id = $msg_data["user_id"];
							$user_message_cat_id = $msg_data["cat_id"];
							
							include("date.php");
							
							$category = mysqli_query($c,"select * from category where cat_id='$user_message_cat_id'");
							while($category_data = mysqli_fetch_array($category))
							{
								$cat_name = $category_data["cat_name"];
							}
							
							
							$user = mysqli_query($c,"select * from user where user_id='$user_message_user_id'");
							while($user_data = mysqli_fetch_array($user))
							{
								$user_name = $user_data["username"];
			
					?>

					<tr>
						<td data-title="ID"><?php echo $user_message_id; ?></td>
						<td data-title="UserID"><?php echo $user_message_user_id; ?></td>
						<td data-title="UserName"><?php echo $user_name; ?></td>
						<td data-title="Message">
							<?php echo $user_message_sms; ?>   
						</td>
						<td data-title="Description" style="word-wrap: break-word;">
							<?php echo $user_message_cat_id; ?>
						</td>
						<td data-title="Time">
	                         <?php echo $ago; ?>
                       </td> 
                       <td data-title="Action">
                       
                      		  <a title="Edit SMS" onClick="edit_user_sms('<?php echo $user_message_id; ?>')" >
                        		  <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
							  
                        	  <a title="Add SMS" href="add_user_sms.php?id=<?php echo $user_message_id; ?>">
                        		  <img src="images/correct.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
							  
                    	      <a title="Delete SMS" onClick="del_confirm('Delete SMS','delete_user_sms.php','<?php echo $user_name; ?>','<?php echo $user_message_id; ?>')" >
                        		  <img src="images/wrong.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
                            
                       </td>
					</tr>
					<?php
						}
					}
					 ?>	 
				</tbody>
		  </table>
		  
	  </section>
    </div> <!-- /container -->
			
	<?php 
		} 
	?>
	
  </body>
</html>
