<?php
	ob_end_flush();
	ob_start();
	session_start(); 
	include("names.php");

if(empty($_SESSION["username"]))
{
	header("location:$url");
}
else
{
	include("header.php");
	require("connect.php");
	include("my_function.php");
	
	mysqli_query($c,"SET NAMES 'utf8'"); 
	mysqli_set_charset($c,"utf8");
	
	
	$id = $_GET["id"];
	
	$user_message_id = mysqli_query($c,"select * from user_message where id='$id'");
	while($user_message_id_data = mysqli_fetch_array($user_message_id))
	{
		$user_message_id_sms = $user_message_id_data["sms"];
		$user_message_id_user_id = $user_message_id_data["user_id"];
		$user_message_id_cat_id = $user_message_id_data["cat_id"];
		$date = $user_message_id_data["date"];
		
		$user_id = mysqli_query($c,"select * from user where user_id='$user_message_id_user_id'");
		while($user_id_data = mysqli_fetch_array($user_id))
		{
			$user_id_name = $user_id_data["username"];
		}
		$category_id = mysqli_query($c,"select * from category where cat_id='$user_message_id_cat_id'");
		while($category_id_data = mysqli_fetch_array($category_id))
		{
			$cat_id_name = $category_id_data["cat_name"];
		}
	}
	
?>


<html>

<head>

	<link rel="stylesheet" type="text/css" href="<?=$adminurl?>/style.css">
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	
	<script type="text/javascript" src="../nicEdit.js"></script>
    
	<script type="text/javascript">
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	</script>
    
    <script>
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
	
 </head>
 
<body>
<div id="mainContent" >
<form name="f1" method="post" accept-charset="utf-8">
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="mainTable roundcorner">
	<tr>
		<td class="subtitle" colspan="5">Add SMS</td>
	</tr>
	
		<tr>
				<td class="field" width="150" valign="top"><strong>Posted By<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><input type="text" name="username" size="55" value="<?php echo $user_id_name?>"></td>
				
		</tr>
		<tr>
				<td class="field" width="150" valign="top"><strong>SMS<span class="sep">:</span></strong></td>
				<td class="field" colspan="1"><textarea name="sms" rows="8" cols="50"><?php echo $user_message_id_sms; ?></textarea></td>
		</tr>
		<tr>
				<td class="field" width="150" valign="top"><strong>Category Name<span class="sep">:</span></strong></td>
				<td class="field" colspan="1">
                	<input type="text" id="tags" name="cat_name" size="55" value="<?php echo $cat_id_name;	?>, ">
 			</td>
				
		</tr>
        <tr>
             <td class="field" width="150" ><strong>Status<span class="sep">:</span></strong></td>
             <td class="field" style="font-size:15px;" >
                    <input type="radio" name="r" value="Active" checked="checked">Active
                    <input type="radio" name="r" value="Deactive">Deactive &nbsp;&nbsp;
             </td>
	    </tr>

		<tr>
			<td class="subtitle1" style="padding-left:150px;" colspan=2>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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

	if(!empty($_POST["username"]) && !empty($_POST["sms"]) && !empty($_POST["cat_name"]))
	{
			
			$status = $_POST["r"];
		
			$sms = $_POST["sms"];
			$sms = trim(ucwords($sms));
			$sms = mysqli_real_escape_string($c,$sms);
					
			$cat_name = $_POST["cat_name"];
			
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
					$cat_insert = mysqli_query($c,"insert into category(cat_name,p_id)values('$cat_name','0')") or die(mysqli_error());
					$last_cat_id = mysqli_insert_id($c);
					$cat_sub_insert = mysqli_query($c,"insert into category_sub (cat_id,cat_name,cat_order,p_id)values('$last_cat_id','$cat_name','$last_cat_id','0')") or die(mysqli_error()); 
					
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
					//$user_insert = mysqli_query($c,"insert into user (username) values ('$username')") or die(mysqli_error());
			}
			
			while($user_data = mysqli_fetch_array($user))
			{
				$user_id = $user_data["user_id"];
				$user_name = $user_data["username"];
			}
		

			$msg_insert = mysqli_query($c,"insert into message(sms,date,status,user_id)values('$sms','$date','$status','$user_id')") or die(mysqli_error());
			
			$sms_id = mysqli_insert_id($c);
			
			foreach($cat_id as $sms_sub_cat_id)
			{
				$cat_msg_count = mysqli_query($c,"UPDATE category SET all_sms = all_sms + 1 WHERE cat_id='$sms_sub_cat_id'");
				
				$sms_sub_insert = mysqli_query($c,"insert into message_sub
				(sms_id,cat_id)values('$sms_id','$sms_sub_cat_id')");
			}	
			
			$user_message_delete = mysqli_query($c,"delete from user_message where id='$id'");
			
			header("location:user_messages.php");
			
	}
}
?>