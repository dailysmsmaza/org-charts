<?php
	ob_end_flush();
	ob_start();

	include("names.php");
	include("header.php");
	include("connect.php");
	
?>

<html>
<head>
        
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
	
		
	<script type="text/javascript">
		
		function edit_menu(id)
		{
			window.location = "edit_menu.php?id="+id;
		}
	</script>
    
</head>
<body>

	 <div class="well well-sm"> <strong> Default Menu </strong> </div>

			<ul id="contextMenu" class="dropdown-menu" role="menu">
				<li><a tabindex="-1" onClick="goback()">Back</a></li>
				<li><a tabindex="-1" onClick="add_category()">Add New Category</a></li>
			</ul>
			
	&nbsp;
		<div id="no-more-tables">
            <table class="col-md-12 table-bordered table-striped table-condensed cf">
        		<thead class="cf">
        			<tr>
        				<th width="5%"><center>ID</center></th>
        				<th width="70%"><center>Name</center></th>
        				<th width="10%"><center>Default</center></th>
        				<th width="20%"><center>Action</center></th>
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
						<td data-title="ID"> 
							<center> <?php echo $default_id; ?>  </center>
						</td> 
						<td data-title="Name"> 
							<center> <?php echo $default_name; ?>  </center>
						</td> 
						<td data-title="Default"> 
							<center> <?php echo $default_pid; ?>  </center>
						</td> 
						<td data-title="Action"> 
							<center>
							<img src="images/edit.png" align="absmiddle" class="action" onClick="edit_menu(<?=$default_id?>)"/>
							</center>
						</td> 
					</tr>
					<?php
						}
					?>
				</tbody>
        	</table>
        </div>
	</div>
</body>
</html>
