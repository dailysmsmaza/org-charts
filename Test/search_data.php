
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