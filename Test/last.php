<?php

	namespace Emojione;
 
    require_once('../emoji/lib/php/autoload.php');
 
    $client = new Client(new Ruleset());
	
	
	include("names.php");
	
	require("connect.php");
	include("counter.php");
	include('config.php');
	include('Emoji.class.php');
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
	
	if($_GET["page"])
	{
		$page = $_GET["page"];
	}
	else
	{
		$page = 1;
	}
	
	
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
		
		function add_sms()
		{
			window.location = "<?=$adminurl?>/add_sms.php?loc=last";	
		}
		
		function del_sms(id,page)
		{
			if(confirm("Do you want to delete category id : "+id))
			 {
					document.location.href="<?=$adminurl?>/del_lastsms.php?id="+id+"&page="+page;
			 }
		}
		
		function goBack()
		{
			window.history.back();
		}
		
	</script>
	
	
  </head>

  <body>

  
    <?php 
		
			include("header.php");	
		
			$adjacents = 2;
			$targetpage = $adminurl."/last.php?page";
			$default_limit = mysqli_query($c,"select * from default_id where id=3");
			$default_limit_pid = mysqli_fetch_row($default_limit);
			$limit = $default_limit_pid[2];
		
	
			$pages_query = mysqli_query($c,"select count(id) from message order by id desc");
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
			  <li><a onClick="add_sms()">Add SMS</a></li>
		   </ul>
		</div>
	 
	  <section id="no-more-tables">
		  
		  <table class="table-bordered table-striped table-condensed cf">
			  <thead class="cf">
				  <tr>
						<th width="5%">ID</th>
						<th width="50%">SMS</th>
						<th width="11%">Cat_Name</th>
						<th width="5%">UserName</th>
						<th width="5%">Like</th>
						<th width="8%">Date</th>
						<th width="7%">Status</th>
						<th width="10%">Action</th>
				  </tr>
			  </thead>
				<tbody>
				
					<tr>
					
				<?php
				
					$msg = mysqli_query($c,"select * from message order by id desc LIMIT $start,$limit");
					
					while($sms_data = mysqli_fetch_array($msg))
					{
						$sms_id = $sms_data["id"];
						$sms = $sms_data["sms"];
						
						
							//$sms = Emoji::html_to_emoji($sms);
						
							
							$sms = $client->shortnameToUnicode($sms);
						
						$likes = $sms_data["likes"];
						$date = $sms_data["time"];
						$status = $sms_data["status"];
						$date_exp = explode(" ",$date);
						$date_data = $date_exp[0];
						$format_date = date('d-m-Y H',strtotime($date_data));	
						$user_id = $sms_data["user_id"];
					
														
						$user = mysqli_query($c,"select * from user where user_id=$user_id");
						while($user_data = mysqli_fetch_array($user))
						{
							$user_id = $user_data["user_id"];
							$user_name = $user_data["username"];
								
					?>
				
					
						 <td data-title="ID"> 
							<?php echo $sms_id; ?>  
						 </td> 
						 
						 <td data-title="SMS">
							<?php echo $sms; ?>								
						</td> 
						 
						 <td data-title="Cat_Name">
						    <?php
									
									$sms_sub = mysqli_query($c,"select * from message_sub where sms_id=$sms_id");
									while($sms_sub_data = mysqli_fetch_array($sms_sub))
									{
										$sms_sub_data_cat_id = $sms_sub_data["cat_id"];
										
										$category = mysqli_query($c,"select * from category where cat_id=$sms_sub_data_cat_id");
										while($category_data = mysqli_fetch_array($category))
										{	
											$category_cat_name = $category_data["cat_name"];
											$category_cat_id = $category_data["cat_id"];
											$category_cat_re_name = str_replace(array(" ","(",")"),array(""),$category_cat_name);
											
									        echo $category_cat_name.", ";						
											
										 }
									
									}
								?>
							</td>
						 
						 
						<td data-title="UserName">
							<?php echo $user_name; ?>								
						</td> 
						 
						<td data-title="Like">  
							<?php echo $likes; 	?>   
						</td>
						
						<td data-title="Date"> 
							<?php echo $date; ?>   
						</td> 
						
						<td data-title="Status"> <?php echo $status; ?>   </td> 
						
						<td data-title="Action"> 
							
							&nbsp;&nbsp; 
                            	<a title="Edit Sms" href="<?=$adminurl?>/edit_sms.php?sms_id=<?php echo $sms_id ?>&id=<?php echo $category_cat_id; ?>&page=<?php echo $page; ?>&loc=last">
                       				 <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                        		</a> 
							
							&nbsp;&nbsp;
                            <a onClick="del_sms('<?php echo $sms_id ?>', '<?php echo $page ?>')" style="cursor:pointer" class="ask">
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
					<div style="text-align:right; margin-right:20px;">  <?php echo $pagination; ?>   <br></div>
					&nbsp;
					&nbsp; 
					&nbsp;
			<?php 
				} 
			?>  
			
			<div style="text-align:right; margin-right:20px;">   </div>
			
			&nbsp;
			&nbsp;
	
	
  </body>
</html>
