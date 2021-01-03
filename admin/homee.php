<?php
	
	include("names.php");
	//include("header.php");
	require("connect.php");
	//include('config.php');
	//include("my_function.php");
	//include("counter.php");
	//include('Emoji.class.php');
	
	$id = $_GET["id"];
	
	//include("chain.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
?>

<html>
<head>

	<meta charset="utf-8">
    <title>Responsive Tables Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://elvery.net/demo/responsive-tables/assets/css/bootstrap.min.css" rel="stylesheet">
	<style>
	
      body { padding-top: 60px; }
	  table { width: 100%; }
	  td, th {text-align: left; white-space: nowrap;}
	  td.numeric, th.numeric { text-align: right; }
	  h2, h3 {margin-top: 1em;}
	  section {padding-top: 40px;}
    </style>
    <link href="https://elvery.net/demo/responsive-tables/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="https://elvery.net/demo/responsive-tables/assets/css/no-more-tables.css" rel="stylesheet">
	<link href="https://elvery.net/demo/responsive-tables/assets/css/prettify.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){<!--   w  w  w . j  a v a2  s. co m-->
//save the selector so you don't have to do the lookup everytime
$dropdown = $("#contextMenu");
$(".actionButton").click(function() {
    //get row ID
    var id = $(this).closest("tr").children().first().html();
    //move dropdown menu
    $(this).after($dropdown);
    
    //show dropdown
    $(this).dropdown();
});
});//]]>  
</script>


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
		function goback()
		{
			window.history.back();
		}
		
	</script>
	
</head>
<body>

        <?php 
		
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
			
			<table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
						<td class="dropdown"><a class="btn btn-default actionButton" data-toggle="dropdown" href="#"> Add / Back </a></td>
					</tr>
        		</thead>
			</table>
			
			<ul id="contextMenu" class="dropdown-menu" role="menu">
				<li><a tabindex="-1" onClick="goback()">Back</a></li>
				<li><a tabindex="-1" onClick="add_category()">Add New Category</a></li>
			</ul>
			

	&nbsp;

    <div class="container-fluid">
	  
	  <section id="no-more-tables">

            <table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
        				<th width="5%">ID</th>
        				<th width="50%">Name</th>
        				<th width="7%">Title</th>
        				<th width="20%">Description</th>
        				<th width="7%">Status</th>
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
					?>
				
						<tr id="order_<?php echo $category_id; ?>">
							
						 <td data-title="ID"> 
							<?php echo $category_id; ?>  
						 </td> 
						 <td data-title="Name">
							
								<a href="<?=$adminurl?>/home.php?id=<?=$category_id?>" title="Go TO Sub Category"> 
									<span class="w3-text-blue"> <?php echo $category_name; ?> </span>
								</a>					
								(<?php echo getcounter($category_id); ?>)
								
							</td> 
						  
						<td data-title="Title">  
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
						
						<td data-title="Description"> 
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
       </div>
		
			&nbsp;
			&nbsp;
			
			<?php
				if(!isset($_GET["limit"]))
				{
			?>
					<div class="pull-right">  <?php echo $pagination; ?>   <br><br> </div>
					 
			<?php 
				} 
			?>  
			
			<div style="text-align:right; margin-right:20px;">  <input type="button" class="btn btn-success" value="Show All" onClick="page_call('home.php?id=<?php echo $id; ?>&limit=all')"> </div>
			
			&nbsp;
			&nbsp;
		<?php
		}
		
		elseif($msg_sub_count>=1)
		{
				$pages_query = mysqli_query($c,"select count(sms_id) from message_sub where cat_id=$id order by sms_id desc ");
				$pages_row = mysqli_fetch_row($pages_query);
				$total_records = $pages_row[0];
				
			
				include("paging.php");
				
		?>
		<table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
						<td class="dropdown"><a class="btn btn-default actionButton" data-toggle="dropdown" href="#"> Add / Back </a></td>
					</tr>
        		</thead>
			</table>
			
			<ul id="contextMenu" class="dropdown-menu" role="menu">
				<li><a tabindex="-1" onClick="goback()">Back</a></li>
				<li><a tabindex="-1" onClick="add_sms()">Add New SMS</a></li>
			</ul>
	
		&nbsp;
	 <div class="container-fluid">
	  
	  <section id="no-more-tables">

            <table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
        				<th width="5%">ID</th>
						<th width="65%">SMS</th>
						<th width="6%">Like</th>
						<th width="8%">Date</th>
						<th width="8%">Status</th>
						<th width="15%">Action</th>
        			</tr>
        		</thead>
        		<tbody>
				
					<tr id="order_<?php echo $category_id; ?>">
					
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
        			</tr>
        		</tbody>
        	</table>
	</section>
      </div>
		
			&nbsp;
			&nbsp;
			
			<?php
				if(!isset($_GET["limit"]))
				{
			?>
					<div style="text-align:right; margin-right:20px;">  <?php echo $pagination; ?>   <br></div>
					 
			<?php 
				} 
			?>  
			
			<div style="text-align:right; margin-right:20px;">  <input type="button" class="btn btn-success" value="Show All" onClick="page_call('home.php?id=<?php echo $id; ?>&limit=all')"> </div>
			
			&nbsp;
			&nbsp;
		<?php
		}
		else
		{
		?>
			
			<table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
						<td class="dropdown"><a class="btn btn-default actionButton" data-toggle="dropdown" href="#"> Add / Back </a></td>
					</tr>
        		</thead>
			</table>
			
			<ul id="contextMenu" class="dropdown-menu" role="menu">
				<li><a tabindex="-1" onClick="goback()">Back</a></li>
				<li><a tabindex="-1" onClick="add_category()">Add New Category</a></li>
				<li><a tabindex="-1" onClick="add_sms()">Add New SMS</a></li>
			</ul>
		
			<div id="no-more-tables">
				<table class="col-md-12 table-bordered table-striped table-condensed cf">
						<tr>
							<th>No Category or SMS Found ! Check above buttons to Add Category or SMS.</th>
						</tr>
				</table>
			</div>
		<?php
		}
		?>
			
</body>
</html>