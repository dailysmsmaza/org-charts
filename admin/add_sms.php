<?php
	ob_end_flush();
	ob_start();

	include("names.php");
	include("header.php");
	require("connect.php");
	
	include('Emoji.class.php');
 
	header('Content-Type: text/html; charset=utf-8');
	
	$default_nm = mysqli_query($c,"select * from default_id where id=1");
	while($default_nm_data = mysqli_fetch_array($default_nm))
	{
		$default_nm_pid = $default_nm_data["pid"];
	}
	
	$default_pid = mysqli_query($c,"select * from default_id where id=2");
	while($default_pid_data = mysqli_fetch_array($default_pid))
	{
		$default_pid_pid = $default_pid_data["pid"];
	}
	
	$id = $_GET["id"];
	
		
?>

<html>
<head>

	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
	
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
		
    <link rel="stylesheet" href="js/jquery-ui.css">
      
    <style>
	
  		.ui-autocomplete-loading
		{
    		background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  		}
		
  </style>
  
  <script src="js/jquery-1.12.4.js"></script>
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
    
</head>
<body>

<ul class="w3-ul w3-card-4">

	<div class="well well-sm"> <center> Add SMS </center> </div>
	 
	<form class="form-horizontal" role="form" name="f1" method="post" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="container">
	
		<div class="form-group">
			<label class="col-sm-10"> Posted By : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" name="username" value="<?=$default_nm_pid?>"/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> SMS : </label>
			<div class="col-sm-7">
				<textarea class="form-control" rows="4" name="sms"></textarea>
			 </div>
		</div>

		<div class="form-group">
			<label class="col-sm-10"> Category Name : </label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="tags" name="cat_name" value="<?php 
									if($id==0)
									{
									}
									else
									{
										$category_default = mysqli_query($c,"select * from category where cat_id='$id'");
										while($category_default_data = mysqli_fetch_array($category_default))
										{
												 $cat_def_name = $category_default_data["cat_name"].", ";
										}
										echo $cat_def_name;
									}
 								?>"/>
			 </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-10"> Status : </label>
			<div class="col-sm-7">
				<input type="radio" name="r" value="Active" checked="checked"> Active
				<input type="radio" name="r" value="Deactive"> Deactive &nbsp;&nbsp;
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
			$id = $_GET["id"];
					
			$status = $_POST["r"];
			$date = strtotime("now");
		
			$sms = $_POST["sms"];
			$sms = str_replace(array("\r\n", "\r", "\n"), "<br />", $sms); 
			$sms = trim(ucwords($sms));
			$sms = Emoji::emoji_to_html($sms);
			//$sms = str_replace(array("<div></div>"),"",$sms);
			//$sms = str_replace(array("<br>"),"<br/>",$sms);
			$sms = str_replace("'","''",$sms);			
			$sms = mysqli_real_escape_string($c,$sms);

			//$sms = htmlspecialchars($sms, ENT_NOQUOTES, "UTF-8");
			
			$cat_name = $_POST["cat_name"];
			
			$cat_name = mysqli_real_escape_string($c,$cat_name);
			
			$username =  $_POST["username"];
			$username = trim(ucwords($username));
			$username =  mysqli_real_escape_string($c,$username);
			
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
						(cat_id,cat_name,cat_order,p_id)values('$last_cat_id','$cat_name','$last_cat_id','0')") or die(mysqli_error()); 
					}
					$category = mysqli_query($c,"select * from category where cat_name='$cat_name'") or die(mysqli_error());
					while($category_data = mysqli_fetch_array($category))
					{
						$cat_id[] = $category_data['cat_id'];
					}
				
				}
			}		
			
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
		
					mysqli_query($c,"SET NAMES 'utf8'"); 
					mysqli_set_charset($c,"utf8");
	
					$msg_insert = mysqli_query($c,"insert into message(sms,date,status,user_id)values('$sms','$date','$status','$user_id')") or die(mysqli_error());
				
					$sms_id = mysqli_insert_id($c);
					
					foreach($cat_id as $sms_sub_cat_id)
					{
								
						$cat_sms = mysqli_query($c,"update category set all_sms = all_sms + 1 where cat_id='$sms_sub_cat_id'");						
						
						$sms_sub_insert = mysqli_query($c,"insert into message_sub
						(sms_id,cat_id)values('$sms_id','$sms_sub_cat_id')");
					}	
			
			
			header("location:$adminurl/home.php?id=$id");
	
	}
		
?>