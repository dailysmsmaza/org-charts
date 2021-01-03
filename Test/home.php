<?php

	namespace Emojione;
 
    require_once('../emoji/lib/php/autoload.php');
 
    $client = new Client(new Ruleset());
	
	
	$id = $_GET["id"];

	include("names.php");
	
	require("connect.php");

	include('config.php');
	
	
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
	
	<script>
		function add_category()
		{
			window.location = "<?=$adminurl?>/add_category.php?id=<?=$id?>";
		}
		
		function add_sms()
		{
			window.location = "<?=$adminurl?>/add_sms.php?id=<?=$id?>&loc=category";	
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
		function goBack()
		{
			window.history.back();
		}
		function showAll(id)
		{
				document.location.href="<?=$adminurl?>/home.php?id="+id+"&limit=all";
		}
		
		function deleteConfirm()
		{
			var result = confirm("Are you sure to delete Messagess?");
			if(result){
				window.location = "delete_multiple.php"
			}else{
				return false;
			}
		}
		$(document).ready(function()
		{
			$('.check:button').toggle(function(){
				$('input:checkbox').attr('checked','checked');
				$("#btnAddProfile").val('Check None');
			},function(){
				$('input:checkbox').removeAttr('checked'); 
				$("#btnAddProfile").val('Check All');				
			})
		})
		
	</script>
	
	
	<script src="jquery.tablednd_0_5.js" type="text/javascript"></script>
	<script src="core.js" type="text/javascript"></script>

	
  </head>

  <body>

  
    <?php 
		
			include("header.php");	
		
			include("chain.php");
		
			$category_sub = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_id");
			$category_sub_count = mysqli_num_rows($category_sub);	
					
			$msg_sub = mysqli_query($c,"select * from message_sub where cat_id=$id order by sms_id desc");
			$msg_sub_count = mysqli_num_rows($msg_sub);					
			
			
			$adjacents = 2;
			$targetpage = $adminurl."/home.php?id=".$id."&page";
			$default_limit = mysqli_query($c,"select * from default_id where id=3");
			$default_limit_pid = mysqli_fetch_row($default_limit);
			$limit = $default_limit_pid[2];
		
			if($category_sub_count>=1)
			{
			
				/* Category Paging */
			
				$pages_query = mysqli_query($c,"select count(cat_id) from category_sub where p_id='$id'");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
			
				include("paging.php");	
	?>
	

 
    <div class="container-fluid">
     
		&nbsp;&nbsp;&nbsp;
		<div class = "btn-group">   
		   <button type = "button" class = "btn btn-default dropdown-toggle" data-toggle="dropdown">
			  Add / Back
			  <span class = "caret"></span>
		   </button>
		   
		   <ul class="dropdown-menu" role="menu">
			  <li><a onClick="goBack()">Back</a></li>
			  <li><a onClick="add_category()">Add Categoy</a></li>
			  <li><a onClick="add_sms()">Add SMS</a></li>
		   </ul>
		</div>
	 
	  <section id="no-more-tables">
			
		  <table class="table-bordered table-striped table-condensed tbl_repeat cf">
			  <thead class="cf">
				  <tr>
						<th width="5%">ID</th>
        				<th width="25%">Name</th>
        				<th width="20%">Title</th>
        				<th width="30%">Description</th>
        				<th width="5%">Status</th>
        				<th width="10%">Action</th>
				  </tr>
			  </thead>
				<tbody>
				
					<?php
			
					if(isset($_GET["limit"]) && $_GET["limit"] == "all")
					{
						$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_order");
					}
					else
					{
						$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_order");
						//$category_sub_data_limit = mysqli_query($c,"select * from category_sub where p_id=$id order by cat_order LIMIT $start,$limit");
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
							$category_all_sms = $category_data["all_sms"];
					?>

					<tr id="order_<?php echo $category_id; ?>">
						<td data-title="ID" style="word-wrap: break-word;"><?php echo $category_id; ?></td>
						<td data-title="Name" style="word-wrap: break-word;">
					
							<a href="<?=$adminurl?>/home.php?id=<?=$category_id?>" title="Go TO Sub Category"> 
									<span class="w3-text-blue"> <?php echo $category_name; ?> </span>
							</a>					
							(<?php echo $category_all_sms; ?>)
												
						</td>
						
						<td data-title="Title" style="word-wrap: break-word;">
							<?php 
								if(!empty($category_title))
								{
									echo $category_title;
								}
								else
								{
									echo "_____";
								}
							?>   
						</td>
						<td data-title="Description" style="word-wrap: break-word;">
							<?php 
								if(!empty($category_description))
								{
									echo $category_description;
								}
								else
								{
									echo "_____";
								}
							?>
						</td>
						<td data-title="Status"> <?php echo $category_status; ?>   </td> 
						
						<td data-title="Action"> 
							
							<a title="Edit Category" href="<?=$adminurl?>/edit_category.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>" >
								<img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
							</a> 
							
							 <a title="Move Category" href="<?=$adminurl?>/move_category.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>"  >
								<img src="images/move.png"  align="absmiddle" class="action" alt="" title="Move Category" border="0" />
							 </a> 
							<a href="<?=$adminurl?>/add_parent.php?id=<?php echo $category_id; ?>&pid=<?php echo $id; ?>" title="Add Parent" >
							<img src="images/copy.png" alt="" title="Add/Remove Parent" border="0"  align="absmiddle" class="action"/>
							</a>
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
		  
	  </section>
    </div> <!-- /container -->
			
			&nbsp;
			&nbsp;
			
			<?php
				if(!isset($_GET["limit"]))
				{
			?>
				<!--	<div class="pull-right">  <?php echo $pagination; ?>   <br><br> </div>
					&nbsp;
					&nbsp; 
					&nbsp;
			<?php 
				} 
			?>  
			
			<div style="text-align:right; margin-right:20px;">  <input type="button" class="btn btn-success" value="Show All" onClick="showAll(<?php echo $id; ?>)"> </div>
			
			&nbsp;
			&nbsp; -->
	<?php 
		} 
		elseif($msg_sub_count>=1)
		{
				$pages_query = mysqli_query($c,"select count(sms_id) from message_sub where cat_id=$id order by sms_id desc ");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
				include("paging.php");
	?>  
	
	<div class="container-fluid">
    <form name="bulk_action_form" action="delete_multiple.php" method="post" onsubmit="return deleteConfirm();"/> 
	
				
	 &nbsp;&nbsp;&nbsp;
		<div class = "btn-group">   
		   <button type = "button" class = "btn btn-default dropdown-toggle" data-toggle="dropdown">
			  Add / Back
			  <span class = "caret"></span>
		   </button>
		   <ul class="dropdown-menu" role="menu">
			  <li><a onClick="goBack()">Back</a></li>
			  <li><a onClick="add_sms()">Add SMS</a></li>
		   </ul>
		</div>
		
		
		 <input type="hidden" name="cat_id_hide" value="<?php echo $_GET["id"]; ?>">
		 <input type="hidden" name="page_no" value="<?php
			if(isset($_GET["page"]))
			{
				echo $_GET["page"];
			}
			else
			{
				echo 1;
			}
		 ?>">
		 
		
	  <section id="no-more-tables">
	  
		 &nbsp;<input type="button" class="check" id="btnAddProfile" value="Check All" /> 
		  
		  <table class="table-bordered table-striped table-condensed cf">
			  <thead class="cf">
				  <tr>
						<th width="5%">ID</th>
						<th width="60%">SMS</th>
						<th width="6%">Like</th>
						<th width="8%">Date</th>
						<th width="8%">Status</th>
						<th width="15%">Action</th>
				  </tr>
				  
			  </thead>
			  
				<tbody>
				 &nbsp;&nbsp;&nbsp;&nbsp; <!-- <input type="submit" name="bulk_delete_submit" value="Delete"/> -->
					<tr>
					
						<?php
			
					if(isset($_GET["limit"]) && $_GET["limit"] == "all")
					{
						$message_sub_count_limit = mysqli_query($c,"select * from message_sub where cat_id=$id ORDER BY sms_id DESC");
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
							$sms = $client->shortnameToUnicode($sms);
							$likes = $sms_data["likes"];
							$date = $sms_data["time"];
							$status = $sms_data["status"];
							$date_exp = explode(" ",$date);
							$date_data = $date_exp[0];
							$format_date = date('d-m-Y',strtotime($date_data));	
					?>
				
					
						 <td data-title="ID"> 
							<?php echo $sms_id; ?>  
						 </td> 
						 <td data-title="SMS">
							<?php echo $sms; ?>								
						</td> 
						  
						<td data-title="Like">  
							<?php echo $likes; 	?>   
						</td>
						
						<td data-title="Date"> 
							<?php echo $format_date; ?>   
						</td> 
						<td data-title="Status"> <?php echo $status; ?>   </td> 
						
						<td data-title="Action"> 
							
							&nbsp;&nbsp; 
                            	<a title="Edit Sms" href="<?=$adminurl?>/edit_sms.php?sms_id=<?php echo $sms_id ?>&id=<?php echo $id ?>&loc=category">
                       				 <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                        		</a> 
							
							&nbsp;&nbsp;
                            <a onClick="del_sms('<?php echo $sms_id ?>', '<?php echo $id ?>')" style="cursor:pointer" class="ask">
                            <img src="images/delete.png" alt="" title="Delete File Category" border="0" class="action" align="absmiddle"/>
                            </a>	
							
							&nbsp;&nbsp;
							<input type="checkbox" name="checked_id[]" value="<?php echo $sms_id; ?>" /> 
							
						</td>
					</tr>
					<?php
						}
					}
					 ?>	 
				</tbody>
		  </table>
		  
	  </section>
	  </form>
    </div> <!-- /container -->

			&nbsp;
			&nbsp;
			
			<?php
				if(!isset($_GET["limit"]))
				{
			?>
					<div style="text-align:right; margin-right:20px;">  <?php echo $pagination; ?>   <br></div>
					&nbsp;
					&nbsp; 
					&nbsp;
			<?php 
				} 
			?>  
			
			<div style="text-align:right; margin-right:20px;">  <input type="button" class="btn btn-success" value="Show All" onClick="showAll(<?php echo $id; ?>)"> </div>
			
			&nbsp;
			&nbsp;
	<?php 
		}
		else
		{
			?>
			
			 <div class="container-fluid">
     
				&nbsp;&nbsp;&nbsp;
				<div class = "btn-group">   
				   <button type = "button" class = "btn btn-default dropdown-toggle" data-toggle="dropdown">
					  Add / Back
					  <span class = "caret"></span>
				   </button>
				   
				   <ul class="dropdown-menu" role="menu">
					  <li><a onClick="goBack()">Back</a></li>
					  <li><a onClick="add_category()">Add Categoy</a></li>
					  <li><a onClick="add_sms()">Add SMS</a></li>
				   </ul>
				</div>
			 
			  <section id="no-more-tables">
					
				  <table class="table-bordered table-striped table-condensed tbl_repeat cf">
					  <thead class="cf">
						  <tr>
							 No Category or SMS Found...!
						  </tr>
					  </thead>
				</table>
			</section>
		</div>
			
			<?php
		}
	?>
	
  </body>
</html>
