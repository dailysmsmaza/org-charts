<?php

	ob_end_flush();
	ob_start();

	include("names.php");
	
	require 'config_keydesc.php'; 

	include("header.php");		

?>

<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>	
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/w3.css" rel="stylesheet">
	<style>
		body { padding-top: 60px; }
		table { width: 100%; }
		td, th {text-align: left;	word-wrap: break-word;}
		h2, h3 {margin-top: 1em;}
		section {padding-top: 40px;}
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="assets/css/no-more-tables.css" rel="stylesheet">

<SCRIPT language=JavaScript>

<?php 
if(isset($_GET["cat"]))
{
?>	var cat_val = <?php echo $_GET["cat"]; ?>;
<?php
}
else
{
?>	var cat_val = "";
<?php
}
?>

function cat_reload(form)
{
	cat_val=form.cat.options[form.cat.options.selectedIndex].value;
	self.location='keydesc.php?cat=' + cat_val ;
}
function page_reload(form)
{
	var page_val=form.page.options[form.page.options.selectedIndex].value;
	self.location='keydesc.php?cat='+cat_val+'&page='+page_val ;
	//self.location='keydesc.php?page='+page_val;
}
</script>
</head>

<body>

<ul class="w3-ul w3-card-4">

	<h3> <center> Choose Category And Page </center> </h3>
		
		<div class="container">
	
			<div class="form-group">

<?Php

@$cat=$_GET['cat']; // Use this line or below line if register_global is off
if(strlen($cat) > 0 and !is_numeric($cat)){ // to check if $cat is numeric data or not. 
echo "Data Error";
exit;
}

@$page=$_GET['page']; // Use this line or below line if register_global is off

$quer2="SELECT * FROM category order by cat_id"; 

if(isset($cat) and strlen($cat) > 0){
$quer="SELECT * FROM page_all where cat_id='".$cat."' order by id"; 
}

$upd_flag = 0;

if( isset($cat) && isset($page) )
{
	$get_key_desc = "SELECT * FROM page_detail where page_number='".$page."' && cat_id='".$cat."' ";
	$get_key_desc_count = $dbo->query($get_key_desc)->fetchAll();
	if(count($get_key_desc_count))
	{
		foreach($dbo->query($get_key_desc) as $get_key_desc_data)
		{
			$key_data = $get_key_desc_data["keywords"];
			$desc_data = $get_key_desc_data["description"];
		}
		$upd_flag = 1;
	}
}

echo "<form method=post name=f1>";

echo "<br>";
echo "<br>";

echo "<center>";

// ------ Category Select Box ------------

echo "<label class='col-sm-10' style='font-size:18px;'> Choose Category : </label>";
echo "<div class='col-sm-4'>";
echo "<select name='cat' onchange=\"cat_reload(this.form)\"><option value=''>Select one</option>";

foreach ($dbo->query($quer2) as $noticia2) 
{
	if($noticia2['cat_id']==@$cat)
	{
		echo "<option selected value='$noticia2[cat_id]'>$noticia2[cat_name]</option>"."<BR>";
	}
	else
	{
		echo  "<option value='$noticia2[cat_id]'>$noticia2[cat_name]</option>";
	}
}
echo "</select>";
echo "</div>";

// ----------------------------------------- //

echo "<br>";

// ------ Page Select Box ------------

echo "<label class='col-sm-10' style='font-size:18px;'> Choose Page : </label>";
echo "<div class='col-sm-4'>";
echo "<select name='page' onchange=\"page_reload(this.form)\"><option value=''>Select one</option>";
	foreach ($dbo->query($quer) as $noticia) 
	{
		if($noticia['page_number']==@$page)
		{
			echo  "<option selected value='$noticia[page_number]'>$noticia[page_number]</option>";
		}
		else
		{
			echo  "<option value='$noticia[page_number]'>$noticia[page_number]</option>";
		}
	}
echo "</select>";
echo "</div>";

// ----------------------------------------- //

echo "<br>";

if( isset($_GET["cat"]) && isset($_GET["page"]) )
{
	echo "<label class='col-sm-10' style='font-size:18px;'> Keyword : </label>";
	echo "<textarea name='keywords' rows='3' style='width:50%'>".(isset($key_data) ? $key_data : "" )."</textarea>";
	
	echo "<br>";
	
	echo "<label class='col-sm-10' style='font-size:18px;'> Description : </label>";
	echo "<textarea name='description' rows='5' style='width:50%'>".( isset($desc_data) ? $desc_data : "" )."</textarea>";
	
	echo "<br>";
	echo "<br>";
	
	echo "<input type=submit value=Save>";
}


echo "</center>";
echo "</form>";

echo "<br>";

echo "<br>";
?>

</div>
</div>

</ul>

</body>

</html>

<?php

if( isset($_GET["cat"]) && isset($_GET["page"]) && isset($_POST["keywords"]) && isset($_POST["description"]) )
{
	$cat_val = $_GET["cat"];
	$page_val = $_GET["page"];
	$keywords = $_POST["keywords"];
	$description = $_POST["description"];
	
	if($upd_flag==1)
	{
		$page_detail = "UPDATE page_detail SET keywords='".$keywords."',description='".$description."' WHERE page_number='".$page_val."' AND cat_id='".$cat_val."' ";
	}
	else
	{
		$page_detail = "INSERT INTO page_detail (page_number,cat_id,keywords,description) values ('".$page_val."','".$cat_val."','".$keywords."','".$description."') ";
	}
	$dbo->query($page_detail);
	
	header("location:keydesc.php?cat=$cat_val");
}
?>