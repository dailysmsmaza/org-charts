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
	$pid = $_GET["pid"];
	
	$category_id = mysqli_query($c,"select * from category_sub where cat_id=$id");
	while($category_id_data = mysqli_fetch_array($category_id))
	{
		$category_id_pid = $category_id_data["p_id"];
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

<?php
	include("chain.php");
?>

<div id="mainContent" >
<form method="post">
	<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">

	<tr>
		<td class="subtitle" colspan="2">Move Category</td>
	</tr>
	
	<tr>
        <td class="field" width="150" valign="top"><strong>Parent ID<span class="sep">:</span></strong></td>
        <td class="field"><input type="text" name="cur_pid"  value="<?=$category_id_pid?>" disabled/></td>
    </tr>
    <tr>
        <td class="field" width="150" ><strong>Change Parent ID<span class="sep">:</span></strong></td>
		<td class="field"><input type="text" name="cha_pid" />		</td>
	</tr>
	
	<tr>
		<td  colspan="2" class="subtitle1" style="padding-left:150px;">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
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
	if(isset($_POST["submit"]))
	{
		
		$pid = $_POST["pid"];
		$id = $_POST["id"];
		$cha_pid = $_POST["cha_pid"];
		$category_upd = mysqli_query($c,"update category_sub set p_id=$cha_pid where cat_id=$id");
		$category_upd = mysqli_query($c,"update category set p_id=$cha_pid where cat_id=$id");
		header("location:$adminurl/home.php?id=$pid");
	}	
}
else
{
	header("location:$url/");
}
?>
