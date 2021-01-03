<?php
	ob_end_flush();
	ob_start();
	session_start();
	include("names.php");
	
if(isset($_SESSION["username"]))
{
	$id = $_GET["id"];
	$pid = $_GET["pid"];
	
	include("header.php");
	require("connect.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");	
		
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<title> Edit Category :: <?=$title?> : Admin Panel </title>
</head>

<?php	
				
			$category = mysqli_query($c,"select * from category where cat_id=$id");
			while($category_data = mysqli_fetch_array($category))
			{	 
				$cat_id_id = $category_data["cat_id"];
				$cat_id_name = $category_data["cat_name"];
				$cat_id_desc = $category_data["cat_description"];
				$cat_id_title = $category_data["cat_title"];
				$cat_id_status = $category_data["status"];
				$cat_id_new = $category_data["new"];
				$cat_id_updated = $category_data["updated"];
				$cat_id_hot = $category_data["hot"];
				$cat_id_cat_app_link = $category_data["cat_app_link"];
				$cat_id_random_app_data = $category_data["random_app_data"];
			}
?>

<body>

<?php
	include("chain.php");
?>

<div id="mainContent" >
<form name="f1" method="post" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	<tr>
		<td class="subtitle" colspan="5">Edit Category</td>
	</tr>
	
		<tr>
				<td class="field" width="150" valign="top"><strong>Category Name<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="name" size="55" value="<?=$cat_id_name?>">
				
		</tr>
		<tr>
				<td class="field" width="150" valign="top"><strong>Category Description<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><textarea name="description" cols="50" rows="6" ><?=$cat_id_desc?></textarea>	
		</tr>
		<tr>
				<td class="field" width="150" valign="top"><strong>Category Title<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="title" size="55" value="<?=$cat_id_title?>">
				
		</tr>
        <tr>
			<td class="field" width="150" ><strong>Status<span class="sep">:</span></strong></td>
			<td class="field" style="font-size:15px;" >
				<input type="radio" name="r" value="Active" <?php if($cat_id_status=="Active"){ ?> checked="checked" <?php } ?> >Active
				<input type="radio" name="r" value="Deactive" <?php if($cat_id_status=="Deactive"){ ?> checked="checked" <?php } ?> >Deactive &nbsp;&nbsp;
        	 </td>
		</tr>
		<tr>
        	<td class="field" width="150" ><strong>Flag<span class="sep">:</span></strong></td>
        	<td class="field" style="font-size:15px;" >
                <input type="checkbox" name="new" value="1" <?php if($cat_id_new=="1"){ ?> checked="checked" <?php } ?> ><span style="text-align:left;margin-left:0px;"> New</span> &nbsp;&nbsp;
                <input type="checkbox" name="updated" value="1" <?php if($cat_id_updated=="1"){ ?> checked="checked" <?php } ?> ><span style="text-align:left;margin-left:0px;"> Updated</span> &nbsp;&nbsp;
                <input type="checkbox" name="hot" value="1" <?php if($cat_id_hot=="1"){ ?> checked="checked" <?php } ?> ><span style="text-align:left;margin-left:0px;"> Hot</span>
						
			</td>
	   </tr>
	   <tr>
        	<td class="field" width="150" ><strong>Images<span class="sep">:</span></strong></td>
        	<td class="field" style="font-size:15px;" >
                <input name="imagefile[]" type="file" multiple="multiple" />
						
			</td>
	   </tr>
	   <tr>
				<td class="field" width="150" valign="top"><strong>App Link<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="app_link" size="55" value="<?=$cat_id_cat_app_link?>">
				
		</tr>
		<tr>
				<td class="field" width="150" valign="top"><strong>App Link Banner<span class="sep">:</span></strong></td>
				<td class="field" colspan="1">
					<input type="file" name="app_link_banner" id="app_link_banner">
				</td/>
		</tr>
		<tr>
			<td class="field" width="150" ><strong>Random App Data<span class="sep">:</span></strong></td>
			<td class="field" style="font-size:15px;" >
				<input type="radio" name="random_app_data" value="1" <?php if($cat_id_random_app_data=="1"){ ?> checked="checked" <?php } ?> >Yes
				<input type="radio" name="random_app_data" value="0" <?php if($cat_id_random_app_data=="0"){ ?> checked="checked" <?php } ?> >No &nbsp;&nbsp;
        	 </td>
		</tr>
        <tr>
			<td class="subtitle1" style="padding-left:150px;" colspan=2>
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
			<input type="submit" class="medium green awesome" style="width:110px" name='submit' value="Save" /> 
			<input type="button" class="medium green awesome" style="width:110px" name="cancel" value="Cancel" onClick="cancel()">
		</tr>
    </table>

</form>
<?php


	if(isset($_POST["submit"]))
	{
		if(!empty($_POST["name"]) && !empty($_POST["r"]))
		{

			$id = $_POST["id"];
			$pid = $_POST["pid"];
			
			$status = $_POST["r"];
			$random_app_data = $_POST["random_app_data"];

			$cat_name = mysqli_real_escape_string($c,$_POST["name"]);
			$cat_name = trim(ucwords($cat_name));
			
			
			$cat_chk = mysqli_query($c,"select * from category where cat_name='$cat_name' AND cat_id!=$id");
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
	
				$cat_app_link = mysqli_real_escape_string($c,$_POST["app_link"]);
				
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
	
				$app_banner_cat_name = "";
				if(isset($_FILES['app_link_banner'])){
				$file_type=$_FILES['app_link_banner']['type'];
				$explode_ext = explode('.',$_FILES['app_link_banner']['name']);
				$file_ext=strtolower(end($explode_ext));
				
				
				$errors= array();
				$target_dir =  "../../images/app_banners/";
				if(!file_exists($target_dir)){
					    mkdir($target_dir);
					}
					$app_banner_cat_name = $cat_name . "." . $file_ext;
				$target_file = $target_dir . $app_banner_cat_name;
				
				$extensions= array("jpeg","jpg","png");
				if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }if(empty($errors)==true){
         move_uploaded_file($_FILES["app_link_banner"]["tmp_name"], $target_file);
         //echo "Success";
      }else{
         print_r($errors);
      }
				}
				
				// Form - Images 
				/*
				$total = count($_FILES['upload']['name']);
				if($total>0){
					$fileFolder = $url+"/dsm/uploads/category_"+$id+"/";
					if(!file_exists($fileFolder)){
					    mkdir($fileFolder);
					}
				// Loop through each file
				for( $i=0 ; $i < $total ; $i++ ) {

				  //Get the temp file path
				  $tmpFilePath = $_FILES['imagefile']['tmp_name'][$i];

				  //Make sure we have a file path
				  if ($tmpFilePath != ""){
				    //Setup our new file path
				    $fileName = $_FILES['upload']['name'][$i];

				    $filePath = $fileFolder+$fileName;

				    //Upload the file into the temp dir
				    if(move_uploaded_file($tmpFilePath, $filePath)) {

				      //Handle other code here
						}
				    }
				  }
				}
				*/


				$category_update = mysqli_query($c,"update category set cat_name='$cat_name',cat_title='$cat_title',cat_description='$description', cat_app_link='$cat_app_link', status='$status', random_app_data='$random_app_data' ,new='$new',updated='$updated',hot='$hot' where cat_id=$id");
				
				$category_sub_update = mysqli_query($c,"update category_sub set cat_name='$cat_name' where cat_id=$id");
				
				//header("location:$adminurl/home.php?id=$pid");
			}
		}
		
		else
		{
			echo "<script> alert('Sorry Field Are Empty'); </script>";
		}
	}
?>

</div>

</body>
</html>

<?php
	include("footer.php");

}
else
{
		header("location:$url/");
}
?>