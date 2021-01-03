<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
	
if(isset($_SESSION["username"]))
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	}
	require("connect.php");	
	include("header.php");

	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
	
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
<title> Add Category :: <?=$title?> : Admin Panel </title>


</head>

<?php

?>

<body>

<?php
	include("chain.php");
?>

<div id="mainContent" >
<form name="f1" method="post">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	<tr>
		<td class="subtitle" colspan="5">Add Category</td>
	</tr>
	<tr>
				<td class="field" width="150" valign="top"><strong>Category Name<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="name" size="55"></td>
				
	</tr>
	<tr>
				<td class="field" width="150" valign="top"><strong>Category Description<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><textarea name="description" cols="50" rows="6"></textarea></td>	
	</tr>
    <tr>
				<td class="field" width="150" valign="top"><strong>Category Title<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="title" size="55"></td>
				
	</tr>
    <tr>
             <td class="field" width="150" ><strong>Status<span class="sep">:</span></strong></td>
             <td class="field" style="font-size:15px;" >
                    <input type="radio" name="r" value="Active" checked="checked">Active
                    <input type="radio" name="r" value="Deactive">Deactive &nbsp;&nbsp;
             </td>
    </tr>
    <tr>
             <td class="field" width="150" ><strong>Flag<span class="sep">:</span></strong></td>
             <td class="field" style="font-size:15px;" >
                            <input type="checkbox" name="new" value="1"><span style="text-align:left;margin-left:0px;"> New</span> &nbsp;&nbsp;
                           <input type="checkbox" name="updated" value="1"><span style="text-align:left;margin-left:0px;"> Updated</span> &nbsp;&nbsp;
                            <input type="checkbox" name="hot" value="1"><span style="text-align:left;margin-left:0px;"> Hot</span>		
			</td>
     </tr>
	 <tr>
			<td class="subtitle1" style="padding-left:150px;" colspan="2">
            <input type="hidden" name="pid" value="<?=$id?>">
			<input type="submit" class="medium green awesome" style="width:110px" name='submit' value="Save" /> 
			<input type="button" class="medium green awesome" style="width:110px" name="cancel" value="Cancel" onClick="cancel()">
			</td>
	 </tr>
</table>
</form>
</div>

</div>

</body>
</html>

<?php
	
	if(isset($_POST["submit"]))
	{
		if(!empty($_POST["name"]) && !empty($_POST["r"]))
		{
			$pid = $_POST["pid"];
			
			$status = $_POST["r"];
			$cat_name = mysqli_real_escape_string($c,$_POST["name"]);
			$cat_name = trim(ucwords($cat_name));
			
			$cat_chk = mysqli_query($c,"select * from category where cat_name='$cat_name'");
			$cat_chk_count = mysqli_num_rows($cat_chk);
			
			if($cat_chk_count>=1)
			{
				echo "<script> alert('This Category Is Already Exist'); </script>";
			}
			else
			{
				$description = mysqli_real_escape_string($c,$_POST["description"]);
				$description =	trim(ucwords($description));
				$cat_title = mysqli_real_escape_string($c,$_POST["title"]);
				$cat_title = trim(ucwords($cat_title));
					
				if(isset($_POST["new"]))
				{
					$new = $_POST["new"];
				}
				else
				{
					$new = "";
				}
				if(isset($_POST["updated"]))
				{
					$updated = $_POST["updated"];
				}
				else
				{
					$updated = "";
				}
				if(isset($_POST["hot"]))
				{
					$hot = $_POST["hot"];
				}
				else
				{
					$hot = "";
				}
				
				$category_insert = mysqli_query($c,"insert into category(cat_name,cat_title,cat_description,status,new,updated,hot,p_id)values('$cat_name','$cat_title','$description','$status','$new','$updated','$hot','$pid')");
				if (mysqli_query($c,$category_insert));
				{
					
					$last_id = mysqli_insert_id($c);
					
					$category_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,cat_order,p_id) values ('$last_id','$cat_name','$last_id','$pid') ");
					
				}
				
				header("location:$adminurl/home.php?id=$id");
			
			}
		
		}
		else
		{
			echo "Sorry Field Are Empty";
		}	

}
?>

<?php
	include("footer.php");
}
else
{
	header("location:$url/");
}
?>