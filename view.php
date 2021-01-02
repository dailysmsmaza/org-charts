<?php
	ob_end_flush();
	ob_start();
	
	include("header.php");
	require("connect.php");
	include("names.php");
	
	
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	$ip_address = $_SERVER['REMOTE_ADDR'];
	


if(isset($_GET["sms_id"]))
{
	$sms_id = $_GET["sms_id"];
	
?>



<!DOCTYPE html>
<html>
<head>

  	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
	<link href="<?php echo $url; ?>/style.css" rel="stylesheet">
   
	<script>
	function addLikes(id,action) {
		$.ajax({
		url: "<?php echo $url; ?>/add_likes.php",
		data:'id='+id+'&action='+action,
		type: "POST",
		beforeSend: function(){
			$('#sms-'+id+' .btn-likes').html("<img src='<?php echo $url; ?>/images/LoaderIcon.gif' />");
		},
		success: function(data){
		var likes = parseInt($('#likes-'+id).val());
		switch(action) {
			case "like":
			$('#sms-'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\')" />');
			likes = likes+1;
			break;
			case "unlike":
			$('#sms-'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\')" />')
			likes = likes-1;
			break;
		}
		$('#likes-'+id).val(likes);
		if(likes>0) {
			$('#sms-'+id+' .label-likes').html(likes+" Like(s)");
		} else {
			$('#sms-'+id+' .label-likes').html('');
		}
		}
		});
	}
	
	// Add custom JS here
$('a[rel=popover]').popover({
  html: true,
  trigger: 'hover',
  placement: 'bottom',
  content: function(){return '<img src="'+$(this).data('img') + '" />';}
});
	</script>
	
	<base href="/">
	
</head>
<body>

<?php include_once("analyticstracking.php"); ?>

<script src="dist/clipboard.min.js"></script> 

	<?php
		include("dist/copy_sms.php");
		
		include("category_menu_pc.php");
	?>

		<div class="col-sm-6">
        	<ul class="w3-ul w3-card-4">
                  <li class="w3-cyan"> <center> View SMS </center> </li>
            </ul>

			<?php
			
				$msg = mysqli_query($c,"select * from message where id='$sms_id' AND status='Active'");
	
				while($msg_data = mysqli_fetch_array($msg))
				{
						$msg_data_sms = $msg_data["sms"];
						
						$msg_data_user_id = $msg_data["user_id"];
						$msg_data_id = $msg_data["id"];
						$msg_data_likes = $msg_data["likes"];
						
						include("date.php");
														
						$user = mysqli_query($c,"select * from user where user_id=$msg_data_user_id");
						while($user_data = mysqli_fetch_array($user))
						{
							$user_id = $user_data["user_id"];
							$user_name = $user_data["username"];
								
						?>
						
				       <?php
include_once('Emoji.class.php');
?>

  <div class="list-group">
                         	<ul> </ul>
          				  	<ul class="w3-ul w3-card-4">
                                <li> 
					<?php
					
						$msg_data_sms = Emoji::html_to_emoji($msg_data_sms);
					
						echo $msg_data_sms; 
					?>
                                </li>
            
                                <blockquote class="blockquote-reverse">
                                  
                                	<footer> <a href="<?php echo $url; ?>/user/sms/<?php echo $user_id; ?>/page/1"> <?php echo $user_name; ?> </a> </footer> 
                                    
                                </blockquote>
                                    
                                          
                                <center> 
                                    <mark> <?php echo $ago; ?> </mark>

   			<?php	
				$copy_sms = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"",$msg_data_sms); 
				$copy_sms = $copy_sms."\n\n";
			?>

                                    <br> <br>		  <a data-text="<?php echo $copy_sms; ?>" data-link="www.dailysmsmaza.com" class="whatsapp"> <img src="images/whatsapp.jpg" title="Whatsapp Share For DailySMSMaza">Whatsapp Send</a>
                                     <br />
					<?php	//$remove_html = strip_tags($msg_data_sms);	?>		 
                                 
										
                                        <span id="sms-<?php echo $msg_data["id"]; ?>">
											<input type="hidden" id="likes-<?php echo $msg_data["id"]; ?>" value="<?php echo $msg_data["likes"]; ?>">
											<?php
											$query ="SELECT * FROM like_ipaddress WHERE sms_id = '" . $msg_data["id"] . "' and ip_address = '" . $ip_address . "'";
											$count = $db_handle->numRows($query);
											$str_like = "like";
											if(!empty($count)) {
											$str_like = "unlike";
											}
											?>
											<span class="btn-likes"><input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes(<?php echo $msg_data["id"]; ?>,'<?php echo $str_like; ?>')" /></span>
											
										</span>
										-
                                    	<button data-tooltip-id="1" data-title="Message Copied" class="btn btn-link trigger" aria-label="<?php echo $copy_sms."www.dailysmsmaza.com"; ?>"> Copy  </button> 
                                        - 
                                        <a href="sms:?body=<?php echo $copy_sms."\n\n www.dailysmsmaza.com"; ?>"> Forward  </a>
                                   
					
                                    <br /> <span class="text-warning"> Tags : </span> 
                                    <?php
									
									$msg_sub = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
									while($msg_sub_data = mysqli_fetch_array($msg_sub))
									{
										$msg_sub_data_cat_id = $msg_sub_data["cat_id"];
										
										$category = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id");
										while($category_data = mysqli_fetch_array($category))
										{	
											$category_cat_name = $category_data["cat_name"];
											$category_cat_id = $category_data["cat_id"];
											$category_cat_re_name = str_replace(array(" ","(",")"),array(""),$category_cat_name);
											
									        ?>                            
                                   			 <a href="<?php echo $url."/sms"."/".$category_cat_id."/".$category_cat_re_name."/page/1"; ?>">  <?php echo $category_cat_name; ?> </a> , 
                                	     <?php
										 }
									
									}
								?>
                          		 </center> 
                            </ul>                                         
						</div>
						
					<script type="text/javascript">

$(document).ready(function() {


var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

    $(document).on("click",'.whatsapp',function() {

if( isMobile.any() ) {

        var text = $(this).attr("data-text");
        var url = $(this).attr("data-link");
        var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
        var whatsapp_url = "whatsapp://send?text="+message;
        window.location.href= whatsapp_url;
} else {
    alert("Please share this sms in mobile device");
}

    });
});
</script>

                <?php	
	
						}
				}
				?>


<?php
	
}

?>
			
			
			<?php  
						$msg_sub_t = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
						while($msg_sub_data_t = mysqli_fetch_array($msg_sub_t))
						{
							$msg_sub_data_cat_id_t = $msg_sub_data_t["cat_id"];
							
							$category_t = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id_t");
							while($category_data_t = mysqli_fetch_array($category_t))
							{	
								$category_cat_name_t[] = $category_data_t["cat_name"];
							}
						}
				
			?>
			
		<?php
		foreach($category_cat_name_t as $all_cat_name)
		{
		?>
			<meta property="og:title" content="<?php echo $all_cat_name.", "; ?>" />
			
		<?php
		}
		?>
	
	<?php 
		$double_quote_remove = str_replace('"','',$msg_data_sms);
		$msg_sms_br_remove = str_replace(array("<br />","<br>","<br/>","</br>","</ br>"),"\n",$double_quote_remove);
		$msg_data_sms_share = Emoji::html_to_emoji($msg_sms_br_remove);
		
	?>
	
	
		<?php
		foreach($category_cat_name_t as $all_cat_name)
		{
		?>
			<title> <?php echo $all_cat_name.", "; ?> </title>
		<?php
		}
		?>
		
		<?php
		foreach($category_cat_name_t as $all_cat_name)
		{
		?>
			<meta name="twitter:title" content="<?php echo $all_cat_name.", "; ?>">
		<?php
		}
		?>
		
    <meta name="description" content="<?php echo $msg_data_sms_share; ?>"> 
    <meta property="og:description" content="<?php echo $msg_data_sms_share; ?>" />
    <meta name="twitter:description" content="<?php echo $msg_data_sms_share; ?>">
	
    <meta property="og:type" content="website" />
	<meta property="og:url" content="https://www.facebook.com/sharer/sharer.php?u=http://www.dailysmsmaza.com/view/sms/<?php echo $sms_id; ?>" />
	
</body>
</html>