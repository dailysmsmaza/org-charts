<?php
 
	ob_end_flush();
	ob_start();

	include("names.php");
	include("header.php");
	require("connect.php");
	include("my_function.php");

?>

<html>
<head>

	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
    
    <script>
		function edit_user_sms(id)
		{
			window.location = "<?=$adminurl?>/edit_user_sms.php?id="+id;
		}
		
	</script>
	
	<style>

@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
	#no-more-tables table, 
	#no-more-tables thead, 
	#no-more-tables tbody, 
	#no-more-tables th, 
	#no-more-tables td, 
	#no-more-tables tr { 
		display: block; 
	}
 
	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
 
	#no-more-tables tr { border: 1px solid #ccc; }
 
	#no-more-tables td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		text-align:left;
		word-wrap: break-word;
		
	}
 
	#no-more-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		font-weight: bold;
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
	
</head>
<body>

 <div class="well well-sm"> <strong> User Messages | </strong> </div>

 <?php
			
            $user_message = mysqli_query($c,"select * from user_message");
			$user_message_count = mysqli_num_rows($user_message);
			
			if($user_message_count>=1)
			{	
	
   			 ?>
				<div id="no-more-tables">
					<table class="col-md-12 table-bordered table-striped table-condensed cf">
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
            			
           			 	<td data-title="ID"> 
						 		<?php echo $user_message_id; ?>  
          		 		</td> 
                        
           			 	 <td data-title="UserID">
						 		<?php echo $user_message_user_id; ?>  
          		 		</td> 
            			<td data-title="UserName">
	                         <?php echo $user_name; ?>
                       </td> 
                        <td data-title="Message">
	                         <?php echo $user_message_sms; ?>
                       </td> 
                       <td data-title="Category">
							<?php echo $cat_name; ?>
                       </td>
                       <td data-title="Time">
	                         <?php echo $ago; ?>
                       </td> 
                       <td data-title="Action">
                       
                      		  <a title="Edit SMS" onClick="edit_user_sms('<?php echo $user_message_id; ?>')" >
                        		  <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
							  
                        	 <a title="Add SMS" onClick="add_confirm('Add SMS','add_user_sms.php','<?php echo $user_name; ?>','<?php echo $user_message_id; ?>')" >
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
        </div>
<?php
            }
            else
			{
			?>
						
				<div id="no-more-tables">
					<table class="col-md-12 table-bordered table-striped table-condensed cf">
							<tr>
								<th>No USER SMS Found</th>
							</tr>
					</table>
				</div>
				
			<?php
			}
			?>
</div>        
</body>
</html>