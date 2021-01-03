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
	
	$category = mysqli_query($c,"select * from category where cat_id=$id");
	while($category_data = mysqli_fetch_array($category))
	{
		$cat_pid = $category_data["p_id"];
		$cat_name = $category_data["cat_name"];
	}
	
	$category_sub = mysqli_query($c,"select * from category_sub where cat_id=$id AND p_id!=$cat_pid");
	$category_sub_count = mysqli_num_rows($category_sub);
	if($category_sub_count>=1)
	{
		while($category_sub_data = mysqli_fetch_array($category_sub))
		{
			$category_sub_pid = $category_sub_data["p_id"];
			$category_sub_pid_all[] = $category_sub_pid;
			$category = mysqli_query($c,"select * from category where cat_id=$category_sub_pid");
			while($category_data = mysqli_fetch_array($category))
			{
				$cat_sub_name[] = $category_data["cat_name"];
			}
		}
		$category_sub_pid_imp = implode(",",$category_sub_pid_all);
		$category_sub_name_imp = implode(",",$cat_sub_name);
	}
?>		
		
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
<title> Add Parent :: <?=$title?> : Admin Panel </title>

</head>
<body>

<?php
	include("chain.php");
?>

<div id="mainContent" >
<form name="f1" method="post">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	<tr>
		<td class="subtitle" colspan="5">Add Parent</td>
	</tr>
	<tr>
				<td class="field" width="150" valign="top"><strong>Parent ID<span class="sep">:</span></strong></td>
				<td class="field" colspan="1">
                <input type="text" name="avail_pid" size="30" value="<?=$cat_pid?>" disabled>
                <input type="text" name="avail_pname" size="30" value="<?=$cat_name?>" disabled>
                </td>
                
	</tr>
   
	<tr>
				<td class="field" width="150" valign="top"><strong>Add Parent ID<span class="sep">:</span></strong></td>
				<td class="field" colspan="1">
                	<input type="text" name="add_pid" size="30" value="<?php if(!empty($category_sub_pid_imp)) echo $category_sub_pid_imp.","; ?>">
                    <input type="text" name="add_pname" size="30" value="<?php if(!empty($category_sub_name_imp)) echo $category_sub_name_imp.","; ?>">
                </td>
				
	</tr>
     <tr>
			<td class="subtitle1" style="padding-left:150px;" colspan="2">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
			<input type="submit" class="medium green awesome" style="width:110px" name='submit' value="Save" /> 
			<input type="button" class="medium green awesome" style="width:110px" name="cancel" value="Cancel" onClick="cancel()">
			</td>
	 </tr>

	
<?php		

		if(isset($_POST["submit"]))
		{
			$id = $_POST["id"];
			$pid = $_POST["pid"];
			
			
			$add_pid = $_POST["add_pid"];
			if(empty($add_pid))
			{
				$delete_parent = mysqli_query($c,"delete from category_sub where cat_id=$id AND p_id!=$cat_pid");
				header("location:$adminurl/home.php?id=$pid");
			}
			else
			{
				$add_pid_exp = explode(",",$add_pid);
				
				$delete_parent = mysqli_query($c,"delete from category_sub where cat_id=$id AND p_id!=$cat_pid");
				
				foreach($add_pid_exp as $all_pid)
				{
					echo $all_pid."</br>";
				
					$category = mysqli_query($c,"select * from category where cat_id=$all_pid");
					$category_count = mysqli_num_rows($category);
					
					if($category_count>=1)
					{
						while($category_data = mysqli_fetch_array($category))
						{
							$category_name = $category_data["cat_name"];
							$category_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,p_id) values ('$id','$category_name','$all_pid')");
						}
						header("location:$adminurl/home.php?id=$pid");
					}
					else
					{
						echo "<script> alert('This Category ID Is Not Available..') </script>";
					}
				}
				
			}
		}


}
else
{
	header("location:$adminurl/home.php?id=$id");
}
	
?>