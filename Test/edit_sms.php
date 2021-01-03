<?php

	namespace Emojione;
 
	include('../emoji/lib/php/autoload.php');
	
	$client = new Client(new Ruleset());
	
	include("names.php");
	require("connect.php");
 
	header('Content-Type: text/html; charset=utf-8');
	
	if(isset($_GET["sms_id"]))
	{
		$id = $_GET["sms_id"]; // $id means sms_id 
		$pid = $_GET["id"]; // $pid means pid          $id and $pid query string variable are changed because chain.php means path can not be displayed,when we use pid as a id after path displayed.
		$loc = $_GET["loc"];
		
		$sms_id = mysqli_query($c,"select * from message where id='$id'");
		while($sms_id_data = mysqli_fetch_array($sms_id))
		{
			$sms_id_sms = $sms_id_data["sms"];
			$sms_id_sms_br = $client->shortnameToUnicode($sms_id_sms);
			$sms_id_sms_br = str_replace("<br />", PHP_EOL, $sms_id_sms);
			//$sms_id_sms_br = str_replace(array("<br/>","<br />","</br>","</br>"),"",$sms_id_sms);
			$user_sms_id = $sms_id_data["user_id"];
			$sms_id_status = $sms_id_data["status"];
			$sms_id_lang = $sms_id_data["lang"];
		}
		
		$user = mysqli_query($c,"select * from user where user_id='$user_sms_id'");
		while($user_data = mysqli_fetch_array($user))
		{
			$user_name = $user_data["username"];
		}
		
		$sms_sub_id = mysqli_query($c,"select * from message_sub where sms_id='$id'");
		while($sms_sub_id_data = mysqli_fetch_array($sms_sub_id))
		{
			$sms_sub_cat_id = $sms_sub_id_data["cat_id"];
			$sms_sub_id_cat_id[] = $sms_sub_cat_id;
			
			$category_sms_id = mysqli_query($c,"select * from category where cat_id=$sms_sub_cat_id");
			while($category_sms_id_data = mysqli_fetch_array($category_sms_id))
			{
				$category_sms_cat_name = $category_sms_id_data["cat_name"];
				$category_sms_id_cat_name[] = $category_sms_cat_name;
			}
		}
		
		$sms_sub_id_cat_id_imp = implode(",",$sms_sub_id_cat_id);
		$category_sub_id_cat_name_imp = implode(",",$category_sms_id_cat_name);
	}
		
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title> Edit SMS :: <?php echo $title; ?> </title>
	
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
	<link href="style.css" rel="stylesheet">
	
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	 
  <link rel='stylesheet' type='text/css' href='../emoji/dist/open_sans.css'>
  <link rel="stylesheet" type="text/css" href="../emoji/dist/normalize.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../emoji/dist/emojione.sprites.css" media="screen">
  
  <link rel="stylesheet" type="text/css" href="../emoji/dist/emojionearea.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../emoji/dist/font-awesome.min.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../emoji/dist/tomorrow.css" media="screen">
  <script type="text/javascript" src="../emoji/dist/jquery.min.js"></script>
  
  <script type="text/javascript" src="../emoji/dist/prettify.js"></script>
  <script type="text/javascript" src="../emoji/dist/emojionearea.js"></script>
	
	<script type="text/javascript">
    $(document).ready(function() {
      $("#smsarea").emojioneArea({
        hideSource: true,
        useSprite: false
      });
    });
  </script>
	
	
  
    <script src="assets/js/bootstrap.min.js"></script>
	<!-- <script src="assets/js/prettify.js"></script> 
	<script src="assets/js/jquery-1.7.1.min.js"></script>	-->
	<script>
		$(function(){
			prettyPrint();
		});
	</script>
	
	<link rel="stylesheet" href="js/jquery-ui.css">
	
	 <style>
	
  		.ui-autocomplete-loading
		{
    		background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  		}
		
  </style>
	
	<script src="js/jquery-ui.js"></script>
	
	 <script>
	
		  $( function() {
			function split( val ) {
			  return val.split( /,\s*/ );
			}
			function extractLast( term ) {
			  return split( term ).pop();
			}
		 
			$( "#tags" )
			  // don't navigate away from the field on tab when selecting an item
			  .on( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
					$( this ).autocomplete( "instance" ).menu.active ) {
				  event.preventDefault();
				}
			  })
			  .autocomplete({
				source: function( request, response ) {
				  $.getJSON( "search.php", {
					term: extractLast( request.term )
				  }, response );
				},
				search: function() {
				  // custom minLength
				  var term = extractLast( this.value );
				  if ( term.length < 2 ) {
					return false;
				  }
				},
				focus: function() {
				  // prevent value inserted on focus
				  return false;
				},
				select: function( event, ui ) {
				  var terms = split( this.value );
				  // remove the current input
				  terms.pop();
				  // add the selected item
				  terms.push( ui.item.value );
				  // add placeholder to get the comma-and-space at the end
				  terms.push( "" );
				  this.value = terms.join( ", " );
				  return false;
				}
			  });
		  } );
  
	</script>
	
	<script>
		function goBack()
		{
			window.history.back();
		}
	</script>
	
  </head>
<body>

<?php
	include("header.php");
	include("chain.php");
?>

<ul class="w3-ul w3-card-6">
	
	<br>
	<br>
	<br>
	<br>
	
	<h5> <center> Add SMS </center> </h5>
	 
	 <div class="container">
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
		<div class="form-group">
			<label class="col-sm-10"> Posted By : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="username" style="width:90%;height:5%" value="<?php echo $user_name; ?>"/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> SMS : </label>
			<div class="col-sm-7">
				<textarea id="smsarea" name="sms"><?php echo $sms_id_sms_br; ?></textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Category Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="cat_name" style="width:60%;height:5%;" value="<?php echo $category_sub_id_cat_name_imp; ?>, "/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Category ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="cat_id" style="width:60%;height:5%;" value="<?php echo $sms_sub_id_cat_id_imp; ?>, " disabled />
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Status : </label>
			<div class="col-sm-7">
				<input type="radio" name="r" value="Active" <?php if($sms_id_status=="Active"){ ?> checked="checked" <?php } ?> > Active
				<input type="radio" name="r" value="Deactive" <?php if($sms_id_status=="Deactive"){ ?> checked="checked" <?php } ?> > Deactive &nbsp;&nbsp;
			</div>
		</div>

		<br>
		
		<div class="form-group">
			<label class="col-sm-10"> Language : </label>
			<div class="col-sm-7">
				<input type="radio" name="lang" value="English" <?php if($sms_id_lang=="English"){ ?> checked="checked" <?php } ?> > English
				<input type="radio" name="lang" value="Hindi" <?php if($sms_id_lang=="Hindi"){ ?> checked="checked" <?php } ?>> Hindi
				<input type="radio" name="lang" value="Gujarati" <?php if($sms_id_lang=="Gujarati"){ ?> checked="checked" <?php } ?>> Gujarati 
			</div>
		</div>
		
		<br>
		
		<div class="form-group" style="margin-left:10px">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goBack()"/>
			
			<input type="hidden" name="sms_id" value="<?php echo $id; ?>">
			<input type="hidden" name="id" value="<?php echo $pid; ?>">
			<input type="hidden" name="location" value="<?php echo $loc; ?>">
			
		</div>
		
		<br>
		<br>
	
	</form>
	
	</div>
	
</ul>

		
  </body>
</html>


<?php
	
	if(isset($_POST["submit"]))
		{
			if(!empty($_POST["sms"]) && !empty($_POST["r"]) && !empty($_POST["cat_name"]))
			{
				
				$id = $_GET["sms_id"];
				$pid = $_GET["id"];
				$location = $_GET["loc"];
				
				if($_GET["page"])
				{
					$page = $_GET["page"];
				}
				
				$r = $_POST["r"];
				$lang = $_POST["lang"];
				
				
				$sms = $_POST["sms"];
				$sms = str_replace(array("\r\n", "\r", "\n"), "<br />", $sms); 
				$sms = ucwords($sms);
				$sms = $client->toShort($sms);
				//$sms = str_replace(array("<div></div>"),"",$sms);
				//$sms = str_replace(array("<br>"),"<br/>",$sms);	
							
				$sms = mysqli_real_escape_string($c,$sms);
				
				$username =  $_POST["username"];
				$username = trim(ucwords($username));
				$username =  mysqli_real_escape_string($c,$username);

				
				$user = mysqli_query($c,"select * from user where username='$username'") or die(mysqli_error());
				$user_count = mysqli_num_rows($user);
				if($user_count >= 1)
				{
				}
				else
				{	
						$user_insert = mysqli_query($c,"insert into user (username) values ('$username')") or die(mysqli_error());
				}
				
				$user_info = mysqli_query($c,"select * from user where username='$username'") or die(mysqli_error());
				
				while($user_data = mysqli_fetch_array($user_info))
				{
					$user_id = $user_data["user_id"];
					$user_name = $user_data["username"];
				}
			
				$msg_upd = mysqli_query($c,"update message set sms='$sms',status='$r',user_id='$user_id',lang='$lang' where id=$id");
				
				$cat_msg_count = mysqli_query($c,"select * from message_sub where sms_id='$id'");
				while($cat_msg_count_data = mysqli_fetch_array($cat_msg_count))
				{
					$cat_msg_count_catid = $cat_msg_count_data["cat_id"];
					
					$get_all_delete_id = getParentID($cat_msg_count_catid);
					foreach($get_all_delete_id as $get_p_all_delete_id)
					{
						if($get_p_all_delete_id!=0)
						{
							$cat_sms = mysqli_query($c,"update category set all_sms = all_sms - 1 where cat_id='".$get_p_all_delete_id."'");
						}
					}
										
					$cat_msg_count_del = mysqli_query($c,"UPDATE category SET all_sms = all_sms - 1 where cat_id='$cat_msg_count_catid'");
				}
				
				$msg_sub_del = mysqli_query($c,"delete from message_sub where sms_id='$id'");
				
				$cat_name = $_POST["cat_name"];
				$cat_name_exp = explode(",",$cat_name);
		
				$cat_count = count($cat_name_exp);
			
				for($i=0;$i<$cat_count - 1;$i++) 
				{
					$cat_name = $cat_name_exp[$i];
					$cat_name = trim(ucwords($cat_name));
					
					$category = mysqli_query($c,"select * from category where cat_name='$cat_name'") or die(mysqli_error());
					$category_count = mysqli_num_rows($category);
					if($category_count >= 1)
					{
						while($category_data = mysqli_fetch_array($category))
						{
							$cat_id[] = $category_data["cat_id"];
						}
					}
					else
					{
						$cat_insert = mysqli_query($c,"insert into category(cat_name,status,p_id)values('$cat_name','Active','0')") or die(mysqli_error());
						if (mysqli_query($c,$cat_insert));
						{
							$last_cat_id = mysqli_insert_id($c);
							
							$cat_sub_insert = mysqli_query($c,"insert into category_sub
(cat_id,cat_name,cat_order,p_id)values('$last_cat_id','$cat_name','$last_cat_id','$default_pid_pid')") or die(mysqli_error()); 
						}
						$category = mysqli_query($c,"select * from category where cat_name='$cat_name'") or die(mysqli_error());
						while($category_data = mysqli_fetch_array($category))
						{
							$cat_id[] = $category_data['cat_id'];
						}
					
					}
				}
				
				foreach($cat_id as $all_cat_id)
				{
					$get_all_id = getParentID($all_cat_id);
					foreach($get_all_id as $get_p_all_id)
					{
						if($get_p_all_id!=0)
						{
							$cat_sms = mysqli_query($c,"update category set all_sms = all_sms + 1 where cat_id='".$get_p_all_id."'");
						}
					}
					$cat_msg_count_add = mysqli_query($c,"UPDATE category SET all_sms = all_sms + 1 WHERE cat_id='$all_cat_id'");
					$msg_sub_insert = mysqli_query($c,"insert into message_sub(sms_id,cat_id)values($id,$all_cat_id)");
				}
				
				
				if($location == "category")
				{
					?>
					<script>
						window.location = "<?php echo $adminurl; ?>/home.php?id=<?php echo $pid; ?>";
					</script>
					<?php
				}
				if($location == "last")
				{
					?>
					<script>
						window.location = "<?php echo $adminurl; ?>/last.php?page=<?php echo $page; ?>";
					</script>
					<?php
				}
			}
		}
		function getParentID($c_id)
		{	

			global $c;
			global $adminhome;
			global $adminurl;

			$cat_sub_id = mysqli_query($c,"select * from category where cat_id='$c_id'");
			while($cat_sub_id_data = mysqli_fetch_array($cat_sub_id))
			{
				$cat_sub_pid = $cat_sub_id_data["p_id"];
				$cat_sub_p_id[] = $cat_sub_pid;
				getParentID($cat_sub_pid);
			}
			if(isset($cat_sub_p_id))
			{
				return $cat_sub_p_id;
			}
		}
?>