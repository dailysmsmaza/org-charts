<?php
	ob_end_flush();
	ob_start();		
	include("names.php");
	include("header.php");
	require("connect.php");
	include("chain.php");
	include_once('Emoji.class.php');
	
	header('Content-Type: text/html; charset=utf-8');

	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");

	if(isset($_GET["sms_id"]))
	{
		$id = $_GET["sms_id"]; // $id means sms_id 
		$pid = $_GET["id"]; // $pid means pid          $id and $pid query string variable are changed because chain.php means path can not be displayed,when we use pid as a id after path displayed.
		
		
		$sms_id = mysqli_query($c,"select * from message where id='$id'");
		while($sms_id_data = mysqli_fetch_array($sms_id))
		{
			$sms_id_sms = $sms_id_data["sms"];
			$sms_id_sms_br = Emoji::html_to_emoji($sms_id_sms);
			//$sms_id_sms_br = str_replace("<br />", PHP_EOL, $sms_id_sms);
			//$sms_id_sms_br = str_replace(array("<br/>","<br />","</br>","</br>"),"",$sms_id_sms);
			$user_sms_id = $sms_id_data["user_id"];
			$sms_id_status = $sms_id_data["status"];
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

<html>
<head>

	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
    
    <script type="application/javascript">
		function goback()
		{
			window.history.back();
		}
	</script>
    
   	<script src="js/jquery-1.12.4.js"></script>
	<script src="js/jquery-ui.js"></script>

     
    <link rel="stylesheet" href="js/jquery-ui.css">
     
    <style>
  		.ui-autocomplete-loading 
		{
    		background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  		}
 	</style>
    
    
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

	<script type="text/javascript" src="../nicEdit.js"></script>
    
	<script type="text/javascript">
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	</script>
	
</head>
<body>

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Edit SMS </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Posted By : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="username" value="<?php echo $user_name?>"/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> SMS : </label>
			<div class="col-sm-7">
				<textarea class="form-control" name="sms" rows="6"><?=$sms_id_sms_br?></textarea>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Category Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="cat_name" value="<?php echo $category_sub_id_cat_name_imp; ?>, "/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Category ID : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="cat_id" value="<?php echo $sms_sub_id_cat_id_imp; ?>, " disabled />
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
		
		<div class="form-group" style="margin-left:10px">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<input class="btn btn-success" type="submit" name="submit" value="Save" />
			<input class="btn btn-danger" type="button" value="Back" onClick="goback()"/>
		</div>
		
	</div>
	
	</form>
	
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
				
				$r = $_POST["r"];
				
				$sms = $_POST["sms"];
				$sms = str_replace(array("\r\n", "\r", "\n"), "<br />", $sms); 
				$sms = trim(ucwords($sms));
				$sms = Emoji::html_to_emoji($sms);
				//$sms = str_replace(array("<div></div>"),"",$sms);
				//$sms = str_replace(array("<br>"),"<br/>",$sms);	
				$sms = str_replace("'","''",$sms);			
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
			
				$msg_upd = mysqli_query($c,"update message set sms='$sms',status='$r',user_id='$user_id' where id=$id");
				
				$cat_msg_count = mysqli_query($c,"select * from message_sub where sms_id='$id'");
				while($cat_msg_count_data = mysqli_fetch_array($cat_msg_count))
				{
						$cat_msg_count_catid = $cat_msg_count_data["cat_id"];
						
						$cat_msg_count_del = mysqli_query($c,"UPDATE category SET  all_sms = all_sms - 1 where cat_id='$cat_msg_count_catid'");
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
						$cat_insert = mysqli_query($c,"insert into category(cat_name,cat_title,status,p_id)values('$cat_name','$cat_name','Active','0')") or die(mysqli_error());
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
					$cat_msg_count_add = mysqli_query($c,"UPDATE category SET all_sms = all_sms + 1 WHERE cat_id='$all_cat_id'");
					$msg_sub_insert = mysqli_query($c,"insert into message_sub(sms_id,cat_id)values($id,$all_cat_id)");
				}
			  header("location:$adminurl/home.php?id=$pid");	
			  
			}
		}
?>