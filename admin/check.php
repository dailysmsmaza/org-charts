<?php
	
	include("names.php");
	//include("header.php");
	require("connect.php");
//	include('config.php');
//	include("my_function.php");
	include("counter.php");
	include('Emoji.class.php');
	
	$id = $_GET["id"];
	
	include("chain.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
?>

<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://elvery.net/demo/responsive-tables/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="https://elvery.net/demo/responsive-tables/assets/css/no-more-tables.css" rel="stylesheet">
	<link href="https://elvery.net/demo/responsive-tables/assets/css/bootstrap.min.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<script src="https://elvery.net/demo/responsive-tables/assets/js/jquery-1.7.1.min.js"></script>
    <script src="https://elvery.net/demo/responsive-tables/assets/js/bootstrap.min.js"></script>
	<script src="https://elvery.net/demo/responsive-tables/assets/js/prettify.js"></script>



	
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
		<div id="no-more-tables">
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
		?>
		
			
</body>
</html>