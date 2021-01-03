<?php


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
	
	<script>
function page_Refresh()
{
	window.location = "test.php";
}

function callCrudAction(action,id) {
	var queryString;
	switch(action) {
		case "English":
			queryString = 'action='+action+'&message_id='+ id;
		break;
		case "Hindi":
			queryString = 'action='+action+'&message_id='+ id;
		break;
		case "Gujarati":
			queryString = 'action='+action+'&message_id='+ id;
		break;
	}	 
	jQuery.ajax({
		url: "add_lang.php",
		data:queryString,
		type: "POST",
		success:function(data){
		
	},
	error:function (){}
	});
   
}		
	</script>
	
	
	<script src="jquery.tablednd_0_5.js" type="text/javascript"></script>
	<script src="core.js" type="text/javascript"></script>

	
  </head>

  <body>

  
    <?php 
		
			include("header.php");	
		
		
		?>
		
	
	<div class="container-fluid">
    <form name="bulk" action="add_lang.php" method="post"/> 
		 
		
	  <section id="no-more-tables">
	  
		<!-- &nbsp;<input type="button" class="check" id="btnAddProfile" value="Check All" /> -->
		  
		  <table class="table-bordered table-striped table-condensed cf">
			  <thead class="cf">
				  <tr>
						<th width="5%">ID</th>
						<th width="60%">SMS</th>
						<th width="15%">Action</th>
				  </tr>
				  
			  </thead>
			  
				<tbody>
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="bulk_delete_submit" value="Delete"/> -->
					<tr>
					
					<?php
					
					
						$adjacents = 2;
						$targetpage = $adminurl."/Lang.php?&page";
						$limit = 50;
						
						$pages_query = mysqli_query($c,"select count(id) from message where lang='' ");
						$pages_row = mysqli_fetch_row($pages_query);
						$total_records = $pages_row[0];
						
						include("paging.php");	
						
						$i = 0;
						
						$msg = mysqli_query($c,"select * from message where lang='' LIMIT $start,$limit");
						while($sms_data = mysqli_fetch_array($msg))
						{
							$sms_id = $sms_data["id"];
							$sms = $sms_data["sms"];
							$sms = Emoji::html_to_emoji($sms);
			
					?>
				
					
						 <td data-title="ID"> 
							<?php echo $sms_id; ?>  
						 </td> 
						 <td data-title="SMS">
							<?php echo $sms; ?>								
						</td> 
						  
						<td data-title="Action"> 
							<?php
							
								$lang_name_arr = array("English","Hindi","Gujarati");
								
								for($j=0;$j<3;$j++)
								{
							?>
									<input type="radio" name="r<?php echo $i; ?>" value="<?php echo $sms_id.$lang_name_arr[$j]; ?>" <?php if($lang_name_arr[$j] == "Hindi") { ?> checked <?php } ?> > <?php echo substr($lang_name_arr[$j],0,3); ?>
							<?php
								}
							?>
						</td>
						
					</tr>
					<?php
						
						$i++;
						}
			
					 ?>	 
				</tbody>
		  </table>
		 
		 <div class="pull-right">
		 
			<div>
				<?php echo $pagination; ?>
			</div>
			
			<br>
				 <input type="submit" value="save" name="submit"> </div>
			<br>
			
		</div>
		
	  </section>
	  </form>

	  
	  <br>
	  <br>

	  </div> <!-- /container -->
		
  </body>
</html>
