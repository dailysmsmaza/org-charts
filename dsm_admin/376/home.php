<?php

	// ob_end_flush();
	// ob_start();
	
	include("names.php");
	
	session_start();
	// echo "nm".$_SESSION['username'];
	if(isset($_SESSION['username']))
	{
		include("header.php");
		require("connect.php");
		include('config.php');
		include("my_function.php");
		// include("counter.php");
		include('Emoji.class.php');
		
		$id = $_GET["id"];
		
		mysqli_query($c,"SET NAMES 'utf8'"); 
		mysqli_set_charset($c,"utf8");
    
?>
<html>
<head>

    <script src="jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="jquery.tablednd_0_5.js" type="text/javascript"></script>
	<script src="core.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
	
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">

	<script>
		function add_category()
		{
			window.location = "<?=$adminurl?>/add_category.php?id=<?=$id?>";
		}
		
		function add_sms()
		{
			window.location = "<?=$adminurl?>/add_sms.php?id=<?=$id?>";	
		}
		function add_smsline()
		{
			window.location = "<?=$adminurl?>/add_sms_line.php";
		}
		function del_category(name,id,pid)
		{
			if(confirm("Do you want to delete category id : "+name))
			 {
					document.location.href="<?=$adminurl?>/del_category.php?id="+id+"&pid="+pid;
			 }
		}
		function del_sms(id,pid)
		{
			if(confirm("Do you want to delete category id : "+id))
			 {
					document.location.href="<?=$adminurl?>/del_sms.php?id="+id+"&pid="+pid;
			 }
		}
		function remove_all_sms(id,pid)
		{
			if(confirm("Do you want to delete all messages : "))
			 {
					document.location.href="<?=$adminurl?>/del_all_sms.php?id="+id+"&pid="+pid;
			 }
		}
		function remove_all_sms_everywhere(id,pid)
		{
			if(confirm("Do you want to delete all messages : "))
			 {
					document.location.href="<?=$adminurl?>/del_all_sms_everywhere.php?id="+id+"&pid="+pid;
			 }
		}
		function goback()
		{
			window.history.back();
		}
		
	</script>
        
</head>
<body>


<?php

		include("chain.php");

		$category_sub = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_id");
		$category_sub_count = mysqli_num_rows($category_sub);	
				
		$msg_sub = mysqli_query($c,"select * from message_sub where cat_id=$id order by sms_id desc");
		$msg_sub_count = mysqli_num_rows($msg_sub);					
		
		
		
		$adjacents = 2;
		$targetpage = $adminurl."/home.php?id=".$id."&page&limit=all";
		$default_limit = mysqli_query($c,"select * from default_id where id=3");
		$default_limit_pid = mysqli_fetch_row($default_limit);
		$limit = $default_limit_pid[2];

?>


	<!-- start #mainContent -->
<div id="mainContent" >
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
    
    <tr>
        <td class="subtitle1" colspan="1" align=''>
		   <?php 
		
			if($category_sub_count>=1)
			{
			
				/* Category Paging */
			
				$pages_query = mysqli_query($c,"select count(cat_id) from category_sub where p_id='$id'");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
			
				include("paging.php");	
					
			?>
        
            
    		<input type="button" name="back" value="Back" onClick="goback()"> | 
        	<input type="button" value="Add New Category" onClick="add_category()">
			
			<input type="button" name="addfile" value="Add New Sms" onClick="add_sms()">
        
	
    	</td> 
    </tr>
    
    <tr>
    	<td colspan=1>
            <table cellpadding="0" cellspacing="1" border="0" width="100%" id="" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
			
           
			<tr>
				<th class="subtitle"  align="center" width="5%">&nbsp;ID</th>
				<th  class="subtitle" align="center" width="50%">&nbsp;Name</th>
				<th  class="subtitle" align="center" width="7%">&nbsp;Title</th>
				<th  class="subtitle" align="center" width="20%">&nbsp;Description</th>
                <th  class="subtitle" align="center" width="7%">&nbsp;Status</th>
				<th  class="subtitle" align="center" colspan="1" width="15%">&nbsp;Action</th>
			</tr>
			<tr><td colspan="8" class="borderbottom"></td></tr>
			<tbody>
            
		<?php
			
			if(isset($_GET["limit"]) && $_GET["limit"] == "all")
			{
				$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_order");
			}
			else
			{
				$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_order LIMIT $start,$limit");
			}
			
			while($category_sub_data=mysqli_fetch_array($category_sub_data_limit))
			{
				$category_sub_cat_id = $category_sub_data["cat_id"];
				
				$category = mysqli_query($c,"select * from category where cat_id=$category_sub_cat_id");
				
				while($category_data = mysqli_fetch_array($category))
				{
					$category_id = $category_data["cat_id"];
					$category_name = $category_data["cat_name"];
					$category_title = $category_data["cat_title"];
					$category_description = $category_data["cat_description"];
					$category_status = $category_data["status"];
					$all_sms = $category_data["all_sms"];
		 ?>
        	
			<tr id="order_<?php echo $category_id; ?>" class="detail">
			
            	 <td align="center" style="word-wrap:break-word;"> <?php echo $category_id; ?>  
                 </td> 
                      
                 <td style="word-wrap:break-word;">
                        <a href="<?=$adminurl?>/home.php?id=<?=$category_id?>&limit=all" title="Go TO Sub Category"> <?php echo $category_name; ?></a>					
						(<?php echo $all_sms; ?>)
                        
                    </td> 
                  
                <td align="center" style="word-wrap-break-word;">  
						<?php echo $category_title; ?> 
                </td>
                
                <td style="word-wrap:break-word;"> <?php echo $category_description; ?>   </td> 
                <td align="center" style="word-wrap:break-word;"> <?php echo $category_status; ?>   </td> 
                
                <td align="center" colspan="1" style="word-wrap-break-word;"> 
              			&nbsp;&nbsp; 
                        <a title="Edit Category" href="<?=$adminurl?>/edit_category.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>" >
                        	<img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                        </a> 
                    	&nbsp;&nbsp;
                         <a title="Move Category" href="<?=$adminurl?>/move_category.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>"  >
                         	<img src="images/move.png"  align="absmiddle" class="action" alt="" title="Move Category" border="0" />
                         </a> 
						&nbsp;&nbsp; 
                        <a href="<?=$adminurl?>/add_parent.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>" title="Add Parent" >
                        <img src="images/copy.png" alt="" title="Add/Remove Parent" border="0"  align="absmiddle" class="action"/>
                        </a>
						&nbsp;&nbsp;
                        <a onClick="del_category('<?php echo $category_name ?>','<?php echo $category_id ?>', '<?php echo $id ?>')" style="cursor:pointer" class="ask">
                        <img src="images/delete.png" alt="" title="Delete File Category" border="0" class="action" align="absmiddle"/>
                        </a>		
               		</td>
             </tr>
            
			<?php
				}
			}
			 ?>	
            </tbody> 
			</table>
            
			  <?php
			 	 if(!isset($_GET["limit"]))
				 {
				?>
           			 <div class="right">  <?php echo $x; ?>   <br><br>
                 
              <?php 
			  	} 
				?>  
            	
                <div class="right">  <input type="button" value="Show All" onClick="page_call('home.php?id=<?php echo $id; ?>&limit=all')">
                
           	</table>
			
			<?php

		  }
		  
			elseif($msg_sub_count>=1)
			{
				$pages_query = mysqli_query($c,"select count(sms_id) from message_sub where cat_id=$id order by sms_id desc ");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
			
				include("paging.php");
				
		?>
            
  
<div id="mainContent" >
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
    <tr>
        <td class="subtitle1" colspan="1" align=''>
				<input type="button" name="back" value="Back" onClick="goback()"> | 
                <input type="button" name="addfile" value="Add New Sms" onClick="add_sms()">
				<input type="button" value="Remove ALL SMS (Category)" onClick="remove_all_sms('<?php echo $id ?>', '<?php echo $id ?>')">
				<input type="button" value="Remove ALL SMS (Everywhere)" onClick="remove_all_sms_everywhere('<?php echo $id ?>', '<?php echo $id ?>')">				
		</td> <!--- sorting only for files--> 
    </tr>
    
    <tr>
    	<td colspan=2>
            <table cellpadding="0" cellspacing="1" border="0" width="100%" id="" class="mainTable roundcorner" style="padding:3px;table-layout:fixed;">

			 <tr>
                	<td colspan="1">
		 <table cellpadding="0" cellpadding="1" border="0" width="100%" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
				<tr>
				<th class="subtitle"  align="center" width="5%">ID</th>
				<th  class="subtitle" align="center" width="70%">SMS</th>
				<th  class="subtitle" align="center" width="6%">Like</th>
                <th class="subtitle"  align="center" width="8%">Date</th>
				<th  class="subtitle" align="center" colspan="1" width="15%">Action</th>
			</tr>
                <tr><td colspan="11" class="borderbottom"></td></tr>

				<?php
					if(isset($_GET["limit"]) && $_GET["limit"] == "all")
					{
						$message_sub_count_limit = mysqli_query($c,"select * from message_sub where cat_id=$id ORDER BY sms_id");
					}
					else
					{
						$message_sub_count_limit = mysqli_query($c,"select * from message_sub where cat_id=$id ORDER BY sms_id DESC LIMIT $start,$limit");
					}
									
					while($msg_sub_data = mysqli_fetch_array($message_sub_count_limit))
					{
						$msg_sub_id = $msg_sub_data["sms_id"];
					
						$msg = mysqli_query($c,"select * from message where id=$msg_sub_id");
						while($sms_data = mysqli_fetch_array($msg))
						{
							$sms_id = $sms_data["id"];
							$sms = $sms_data["sms"];
							$sms = Emoji::html_to_emoji($sms);
							$likes = $sms_data["likes"];
							$date = $sms_data["time"];
							$date_exp = explode(" ",$date);
							$date_data = $date_exp[0];
							$format_date = date('d-m-Y',strtotime($date_data));	
					?>
					
                    	<tr class="detail">
                            		
                          <td width="3%" align="center" style="word-wrap:break-word;"> <?php echo $sms_id; ?> </td>
                          <td width="100%" style="word-wrap:break-word;"> <?php echo $sms; ?> </td> 
                          <td width="5%" align="center" style="word-wrap-break-word;"> <?php echo $likes; ?> </td>
                          <td width="3%" align="center" style="word-wrap:break-word;"> <?php echo $format_date; ?> </td>
                          <td width="15%" align="center" colspan="1" style="word-wrap-break-word;"> 
                            &nbsp;&nbsp; 
                            	<a title="Edit Sms" href="<?=$adminurl?>/edit_sms.php?sms_id=<?php echo $sms_id ?>&id=<?php echo $id ?>">
                       				 <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                        		</a> 
							
							&nbsp;&nbsp;
                            <a onClick="del_sms('<?php echo $sms_id ?>', '<?php echo $id ?>')" style="cursor:pointer" class="ask">
                            <img src="images/delete.png" alt="" title="Delete File Category" border="0" class="action" align="absmiddle"/>
                            </a>		
                          </td>
						</tr>
							<?php
						}
					}
						?>
					 </table>
			<?php
			 	 if(!isset($_GET["limit"]))
				 {
				?>
           			 <div class="right">  <?php echo $x; ?>   <br><br>
                 
                <?php } ?>  
            	<div class="right">  <input type="button" value="Show All" onClick="page_call('home.php?id=<?php echo $id; ?>&limit=all')">
                
				</table>
			<?php
			}
			else
			{
		?>
        	 <div id="mainContent" >
				<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
 				   <tr>
  				      <td class="subtitle1" colspan="1" align=''>
						<input type="button" name="back" value="Back" onClick="goback()"> | 
   			            <input type="button" name="addfile" value="Add New Category" onClick="add_category()">
                         <input type="button" name="addfile" value="Add New SMS" onClick="add_sms()">
					</td> <!--- sorting only for files--> 
   				  </tr>
				 
                 <tr>
    				<td colspan=1>
            			<table cellpadding="0" cellspacing="1" border="0" width="100%" id="" class="tbl_repeat mainTable roundcorner" style="padding:3px;table-layout:fixed;">
        					 <tr>
            					<td class="subtitle" align="left">No Category or File Found ! Check above buttons to Add Category or File.</td>
							</tr>
            		   </table>
                   </td>
                </tr>
			</table>
            </div>
		   <?php
			}
			?>
          
	</div>
</div>
</body>
</html>
<?php
	} else {
		echo "Not A Valid User";
	}
?>