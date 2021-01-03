<?php
 
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
	
	if(isset($_SESSION["username"]))
	{
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

</head>
<body>

<div class="path"> 
	<span class="title"> User Messages |  </span>
</div>

<div class="mainContent">

<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	
           <?php
			
            $user_message = mysqli_query($c,"select * from user_message");
			$user_message_count = mysqli_num_rows($user_message);
			
			if($user_message_count>=1)
			{	
	
   			 ?>
    <tr>
		<td colspan="1">
		 <table cellpadding="0" cellpadding="1" border="0" width="100%" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
     		<tr>
	            <th  class="subtitle"  align="center" width="5%">ID</th>
				<th  class="subtitle"  align="center" width="6%">User ID</th>
				<th  class="subtitle" align="center" width="10%">User Name</th>
				<th  class="subtitle" align="center" width="60%">Message</th>
                <th  class="subtitle" align="center" colspan="1" width="10%">Category</th>
				<th  class="subtitle" align="center" colspan="1" width="10%">Time</th>
                <th  class="subtitle" align="center" colspan="1" width="12%">Action</th>
			</tr>
            <tr><td colspan="8" class="borderbottom"></td></tr>
	
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
            
           			 <tr class="detail">
            			
           			 	 <td  align="center" style="word-wrap:break-word;"> 
						 		<?php echo $user_message_id; ?>  
          		 		</td> 
                        
           			 	 <td  align="center" style="word-wrap:break-word;"> 
						 		<?php echo $user_message_user_id; ?>  
          		 		</td> 
            			<td style="word-wrap:break-word;" align="center">
	                         <?php echo $user_name; ?>
                       </td> 
                        <td style="word-wrap:break-word;" align="center">
	                         <?php echo $user_message_sms; ?>
                       </td> 
                       <td style="word-wrap:break-word;" align="center">
							<?php echo $cat_name; ?>
                       </td>
                       <td style="word-wrap:break-word;" align="center">
	                         <?php echo $ago; ?>
                       </td> 
                       <td style="word-wrap:break-word;" align="center">
                       
                       		&nbsp;&nbsp; 
                      		  <a title="Edit SMS" onClick="edit_user_sms('<?php echo $user_message_id; ?>')" >
                        		  <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
                              
                    		&nbsp;&nbsp;
                        	 <a title="Add SMS" onClick="add_confirm('Add SMS','add_user_sms.php','<?php echo $user_name; ?>','<?php echo $user_message_id; ?>')" >
                        		  <img src="images/correct.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
                          
							&nbsp;&nbsp; 
                    	      <a title="Delete SMS" onClick="del_confirm('Delete SMS','delete_user_sms.php','<?php echo $user_name; ?>','<?php echo $user_message_id; ?>')" >
                        		  <img src="images/wrong.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                              </a> 
                            
                       </td>
                       </tr>
            <?php
					}
				}
				?>
			</table>
            </td>
            </tr>
<?php
            }
            else
			{
			?>
				<tr>    
                	<td colspan=1>
            			<table cellpadding="0" cellspacing="1" border="0" width="100%" id="" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
							<tr> 
               					 	<td class="subtitle" align="center">No User Messages Found ! 	</td> 
                			</tr>
               
            		</table>
                  </td>
                </tr>
			<?php
			}
			?>
</div>        
</body>
</html>

<?php
	}
?>