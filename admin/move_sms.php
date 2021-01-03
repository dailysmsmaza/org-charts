<?php
	ob_end_flush();
	ob_start();
	session_start();
	
include("start_session.php");

	include("header.php");
	include("connect.php");
	include("names.php");
	
	$id = $_GET["id"];
	$pid = $_GET["pid"];
	$get_data = mysqli_query($c,"select * from message where id=$id");
	while($r=mysqli_fetch_array($get_data))
	{
		$cat_id = $r["cat_id"];
		$cat_id_explode = explode(",",$cat_id);
		$cat_id_count = count($cat_id_explode);
		for($i=0;$i<=$cat_id_count;$i++)
		{
			$cat_get = mysqli_query($c,"select * from category where cat_id=$cat_id_explode[1]");
			while($cat_data = mysqli_fetch_array($cat_get))
			{
				$cat_name = $cat_data["cat_name"];
			}
		}
	}

?>

<html>
<head>
	<script>
		function goBack()
		{
			window.history.back();
		}
	</script>
</head>
<body>

<div class="path">
	<span class="title">
    	Categories  | 
    </span>
</div>

<div id="mainContent" >
<form method="post">
	<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">

	<tr>
		<td class="subtitle" colspan="2">Move Category</td>
	</tr>
	
    <tr>
        <td class="field" width="150" ><strong>Change Boss<span class="sep">:</span></strong></td>
		<td class="field"><input type="text" name="chanboss" value="<? echo $cat_id; ?>" />		</td>
	</tr>
	 <tr>
        <td class="field" width="150" ><strong>Change Boss<span class="sep">:</span></strong></td>
		<td class="field"><input type="text" name="chanboss" value="<? echo $cat_name; ?>" />		</td>
	</tr>
	<tr>
		<td  colspan="2" class="subtitle1" style="padding-left:150px;">
			<input type="submit" name="submit" value="Save" />
			<input type="button" name="Cancel" value="Cancel" onClick="goBack()" />
		</td>
	</tr>
	
</table>
</form>
</div>
</body>
</html>


		
<?php
	if($_POST["submit"])
	{
		$mid = $_POST["chanboss"];
		$sql = mysqli_query($c,"update message set cat_id='$mid' where id=$id");
		header("location:$adminurl/home.php?id=$pid");
	}	
	
?>

<?php include("end_session.php"); ?>