<?php
 
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");

		include("header.php");
		require("connect.php");
		include("my_function.php");
?>

<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/w3.css" rel="stylesheet">
	<style>
		body { padding-top: 60px; }
		table { width: 100%; }
		td, th {text-align: left;word-wrap: break-word;}
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

<!--	
	Search Ajax
<script type="text/javascript">

$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "search_data.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});

jQuery("#result").live("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery("#result").fadeOut(); 
    }
});
$('#searchid').click(function(){
    jQuery("#result").fadeIn();
});
});
</script>

-->

</head>

<body>
	<ul class="w3-ul w3-card-4">
		<br>
			
			<div style="margin-left:5%">
				<form method="post">
					<input type="text" class="search" name="search" id="searchid" placeholder="Search for SMS" style="width:90%;height:7%;" value="<?php if($_POST["search"]) { echo $_POST["search"]; } ?>"/>
					<input type="submit" name="searchbtn" value="Search" style="font-size: 24px;"  />
				</form>
			</div>
			
		<br>
	</ul>
	

</body>

</html>


<?php
include('connect.php');
include_once("names.php");
if($_POST)
{
	$q=$_POST['search'];
	$sql_res = mysqli_query($c,"select id,sms from message where sms like '%$q%' order by id LIMIT 50");

?>

<html>
<head>
		<script>
			function del_sms(id,pid)
			{
				if(confirm("Do you want to delete category id : "+id))
				 {
						document.location.href="<?=$adminurl?>/del_sms.php?id="+id+"&pid="+pid;
				 }
			}
		</script>
</head>

<body>

<div class="container-fluid">
      
	  <section id="no-more-tables">
			
		  <table class="table-bordered table-striped table-condensed tbl_repeat cf">
			  <thead class="cf">
				  <tr>
						<th width="7%">ID</th>
						<th width="80%">Message</th>
						<th width="10%">Action</th>
				  </tr>
			  </thead>
				<tbody>
				
				<?php

while($row = mysqli_fetch_array($sql_res))
{
	$id = $row['id'];
	$sms = $row['sms'];
	$b_id = '<strong>'.$q.'</strong>';
	$b_sms = '<strong>'.$q.'</strong>';
	$final_id = str_ireplace($q, $b_id, $id);
	$final_sms = str_ireplace($q, $b_sms, $sms);
?>
		
				<tr>
						<td data-title="ID"><?php echo $final_id; ?></td>
						<td data-title="Message"><?php echo $final_sms; ?></td>
						
						<td data-title="Action"> 
							
							&nbsp;&nbsp; 
                            	<a title="Edit Sms" href="<?=$adminurl?>/edit_sms.php?sms_id=<?php echo $id; ?>&id=<?php echo "last"; ?>">
                       				 <img src="images/edit.png" alt="" title="" border="0"  align="absmiddle" class="action"/> 
                        		</a> 
							
							&nbsp;&nbsp;
                            <a onClick="del_sms('<?php echo $id ?>', '<?php echo "search"; ?>')" style="cursor:pointer" class="ask">
                            <img src="images/delete.png" alt="" title="Delete File Category" border="0" class="action" align="absmiddle"/>
                            </a>	
							
							&nbsp;&nbsp;
							<input type="checkbox" name="checked_id[]" value="<?php echo $id; ?>" /> 
							
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

</body>

</html>