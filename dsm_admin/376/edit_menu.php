<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
if(isset($_SESSION["username"]))
{
	include("header.php");
	include("connect.php");
	
	$id = $_GET["id"];
	
	$default_id = mysqli_query($c,"select * from default_id where id=$id");
	while($default_id_data = mysqli_fetch_array($default_id))
	{
		$default_id_name = $default_id_data["name"];
		$default_id_pid = $default_id_data["pid"];
	}
	
	
?>	

<html>
<head>
		<script type="text/javascript">
			function goback()
			{
				window.history.back();
			}
		</script>
</head>
<body>
<div id="mainContent" >
<form name="f1" method="post">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	<tr>
		<td class="subtitle" colspan="5">Default Menu Item Edit</td>
	</tr>
	<tr>
				<td class="field" width="150" valign="top"><strong>Name<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="name" size="55" value="<?=$default_id_name?>" disabled></td>
				
	</tr>	
    <tr>
				<td class="field" width="150" valign="top"><strong>Default<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="pid" size="55" value="<?=$default_id_pid?>"></td>
				
	</tr>
    <tr>
			<td class="subtitle1" style="padding-left:150px;" colspan="2">
            <input type="hidden" name="id" value="<?=$id?>">
			<input type="submit" class="medium green awesome" style="width:110px" name='submit' value="Save" /> 
			<input type="button" class="medium green awesome" style="width:110px" name="cancel" value="Cancel" onClick="goback()">
			</td>
	</tr>	
</table>	
</form>
</div>
</body>
</html>
	
	
	
<?php	
	
	if(isset($_POST["submit"]))
	{
			$p_id = $_POST["pid"];
			$id = $_POST["id"];
			$default_update = mysqli_query($c,"update default_id set pid='$p_id' where id=$id");
			header("location:$adminurl/default_menu.php");
	}
	
	
	
}
else
{
	header("location:$url");
}