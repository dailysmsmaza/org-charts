<?php
	namespace Emojione;
    require('emoji/lib/php/autoload.php');
    $client = new Client(new Ruleset());

	include("header.php");
	include("connect.php");
	include("names.php");

	$id = $_GET["c_id"];
	
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	
	global $counter;
	$cat_id = mysqli_query($c,"select * from category where cat_id=$id");
	while($cat_id_data = mysqli_fetch_array($cat_id))
	{
		$cat_id_id = $cat_id_data["cat_id"];
		$cat_id_name = $cat_id_data["cat_name"];
		$cat_id_rename  = str_replace(array(" ","(",")"),array(""),$cat_id_name);
		$cat_id_desc = $cat_id_data["cat_description"];
		$cat_id_title = $cat_id_data["cat_title"];
	}

	if(isset($_GET["c_id"]) && isset($_GET["page"]) )
	{
		$get_page_cat_id = $_GET["c_id"];
		$get_page_page = "page".$_GET["page"];
		
		$get_page = mysqli_query($c,"select * from page_detail where page_number='".$get_page_page."' AND cat_id='".$get_page_cat_id."'");
		
		while($get_page_data = mysqli_fetch_array($get_page))
		{
			$get_page_keywords = $get_page_data["keywords"];
			$get_page_description = $get_page_data["description"];
		}
		
	}
	/*
	function truncate_words($trunc_msg_data_sms, $trunc_msg_limit, $trimmarker) 
	{
		$trunc_count = str_word_count($trunc_msg_data_sms, 0);
		$trunc_msg_data_sms = explode(' ', $trunc_msg_data_sms, $trunc_msg_limit + 1);
		array_pop($trunc_msg_data_sms);
		$trunc_msg_data_sms = implode(' ', $trunc_msg_data_sms);
		return ($trunc_msg_limit < $trunc_count) ? $trunc_msg_data_sms . $trimmarker : $trunc_msg_data_sms;
	}
	*/
?>	

<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
    <base href="/">

    <title> <?php echo $cat_id_title; ?> :: <?php echo $title; ?> </title>
    
	<meta name="keywords" content="<?php if(!empty($get_page_keywords)) { echo $get_page_keywords; } else { echo $cat_id_title; }?>">
	<meta name="description" content="<?php if(!empty($get_page_description)) { echo $get_page_description; } else { echo $cat_id_title; }?>">  
        
    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css"> 
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">
    
	<script type="text/javascript">

$(document).ready(function() 
{

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
        <!-- var url = $(this).attr("data-link"); -->
        var message = encodeURIComponent(text);<!-- +" - "+encodeURIComponent(url); -->
        var whatsapp_url = "whatsapp://send?text="+message;
        window.location.href= whatsapp_url;
} else {
    alert("Please share this sms in mobile device");
}

    });
});
</script>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
	
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
	</script>
	

	<script>
	
	$(function () {
	
		$(document).on('click', '.trigger', function () {
			$(this).addClass("on");
			$(this).tooltip({
				items: '.trigger.on',
				position: {
					my: "left+30 center",
					at: "right center",
					collision: "flip"
				},
				delay:1000
			});
			$(this).trigger('mouseenter');
		});		
	});
	
	</script>
	
	
</head>
<body>

<?php include_once("analyticstracking.php"); ?>

	 <script src="dist/clipboard.min.js"></script>
         	
<?php
	include("dist/copy_sms.php");

	include("category_menu_pc.php");
	
	include("customeFunction.php");
		
	$adjacents = 2;
	
	$targetpage = $url."/sms/".$id."/".$cat_id_rename."/page";
	
	
	$default_limit = mysqli_query($c,"select * from default_id where id=2");
	$default_limit_pid = mysqli_fetch_row($default_limit);
	$limit = $default_limit_pid[2];
	
	$default_limit = mysqli_query($c,"select * from default_id where id=4");
	$default_limit_pid = mysqli_fetch_row($default_limit);
	$msg_limit = $default_limit_pid[2];
	
	$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='$ip_address'");
	$get_lang_count = mysqli_num_rows($get_lang);
	while($get_lang_data = mysqli_fetch_array($get_lang))
	{
		$language = $get_lang_data["lang_name"];
		if($language=="English")
		{
			$english = "English";
		}
		if($language=="Hindi")
		{
			$hindi = "Hindi";
		}
		if($language=="Gujarati")
		{
			$gujarati = "Gujarati";
		}
	}
	
	if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
	{
		$pages_query = mysqli_query($c,"SELECT count(id) FROM message_sub WHERE cat_id='".$id."' AND sms_id IN (SELECT id FROM message WHERE lang='".$english."' OR lang='".$hindi."' OR lang='".$gujarati."') order by id desc");
	}
	else
	{
		$pages_query = mysqli_query($c,"select count(id) from message_sub where cat_id='$id' order by id desc");
	}
	$pages_row = mysqli_fetch_row($pages_query);
	$total_records = $pages_row[0];
	

	include("paging.php");

?>

	
			<div class="col-md-6"> 
				<?php include_once("chain.php"); ?>
				<ul class="w3-ul w3-card-4">
					<li class="w3-cyan"> 
						<center> 
							<?php echo $cat_id_name; ?> 
							<span class="badge"> 
								<?php echo $total_records; ?> 
								SMS 
							</span> 
						</center> 
					</li>
				</ul>
               
				<?php
				// order by sms_id desc LIMIT $start,$limit
				if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
				{
					$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' AND  sms_id IN (SELECT id FROM message WHERE lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."') order by id desc LIMIT $start,$limit");
				}
				else
				{
					$sub_message = mysqli_query($c,"select * from message_sub where cat_id='$cat_id_id' order by id desc LIMIT $start,$limit");
				}
				
					$sub_message_count = mysqli_num_rows($sub_message);
				
					if($sub_message_count>0)
					{
						while($sub_message_data = mysqli_fetch_array($sub_message))
						{
							$sub_message_sms_id = $sub_message_data["sms_id"];
							
							$msg = mysqli_query($c,"select * from message where id='".$sub_message_sms_id."' AND status='Active'");
			
							while($msg_data = mysqli_fetch_array($msg))
							{
								$msg_data_id = $msg_data["id"];
								$msg_data_sms = $msg_data["sms"];
								$msg_data_user_id = $msg_data["user_id"];
								
								//$trimmarker = "... <a href=''> Read More </a>";
				
								//$msg_data_sms = truncate_words($msg_data_sms,$msg_limit,$trimmarker);
				
								
								include("date.php");
								
								$user = mysqli_query($c,"select * from user where user_id=$msg_data_user_id");
								while($user_data = mysqli_fetch_array($user))
								{
									$user_id = $user_data["user_id"];
									$user_name = $user_data["username"];
				?>
				
									<div class="list-group">
						<ul> </ul>
						<ul class="w3-ul w3-card-4">
							<li> 
								<?php
									$msg_data_sms = $client->shortnameToUnicode($msg_data_sms);
									//$trimmarker = "... <a href=''> Read More </a>";
									
									//$msg_data_sms = truncate_words($msg_data_sms,$msg_limit,$trimmarker);
									echo $msg_data_sms;
								?>
							</li>
								
							<blockquote class="blockquote-reverse">                          
								<footer> <a href="<?php echo $url; ?>/user/sms/<?php echo $user_id; ?>/page/1"> <?php echo $user_name; ?> </a> </footer> 
							</blockquote>
														
															 
							<center> 
								<mark> <?php echo $ago; ?> </mark>

								<?php	
								
									$email_sms = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"%0A",$msg_data_sms); 
									$double_quote_remove = str_replace(array('"','"',':'),'',$email_sms);
									$email_sms_double_quote_remove = str_replace('"',"''",$email_sms);
									
									$msg_double_quote_remove = str_replace('"',"''",$msg_data_sms);
									$msg_data_br_remove = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"",$msg_data_sms); 
									$msg_data_br_to_n = str_replace(array("<br/>","<br>","<br />","</ br>","</br>"),"\n",$msg_double_quote_remove); 
									
									$msg_data_br_to_n_add_line = $msg_data_br_to_n."\n\n";
									$msg_data_add_line = $msg_data_br_remove."\n\n";
									
								?>

								<br> <br>
									
									<a data-text="<?php echo $msg_data_br_to_n."\n\n"; ?>" class="whatsapp"> 
										<img src="images/whatsapp.png" title="Whatsapp Share For DailySMSMaza">
									</a>
									
									<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.dailysmsmaza.com/view/sms/<?php echo $msg_data_id; ?>" target="_blank" title="Share on Facebook">
										<img alt="Share on Facebook" src="images/facebook.png">
									</a> 								
															
									<!-- <a href="https://twitter.com/intent/tweet?source=http://www.dailysmsmaza.com/view/sms/<?php //echo $double_quote_remove; ?>&amp;text=<?php //echo $email_sms; ?>&amp;via=dailysmsmaza" target="_blank" title="Tweet"><img alt="Tweet" src="images/twitter.png"></a> -->
									
									<a href="https://plus.google.com/share?url=http://www.dailysmsmaza.com/view/sms/<?php echo $msg_data_id; ?>" target="_blank" title="Share on Google+">
										<img alt="Share on Google+" src="images/google-plus.png">
									</a>
															
									<a href="mailto:?subject=
										<?php
											$msg_sub_t = mysqli_query($c,"select * from message_sub where sms_id=$msg_data_id");
											while($msg_sub_data_t = mysqli_fetch_array($msg_sub_t))
											{
												$msg_sub_data_cat_id_t = $msg_sub_data_t["cat_id"];
												
												$category_t = mysqli_query($c,"select * from category where cat_id=$msg_sub_data_cat_id_t");
												while($category_data_t = mysqli_fetch_array($category_t))
												{	
													 $category_cat_name_t = $category_data_t["cat_name"];
													 echo $category_cat_name_t.", ";
												}
											}
										?> 
										&amp;body=<?php echo $email_sms_double_quote_remove; ?>" target="_blank" title="Send an email : www.dailysmsmaza.com"> 
										<img alt="Send an email : www.dailysmsmaza.com" src="images/email.png">
									</a>
									
									<a href="sms:?body=<?php echo $email_sms_double_quote_remove."%0A %0A"; ?>"> 
										<img alt="Send an Message : www.dailysmsmaza.com" src="images/message.png">
									</a>
									
									<br />              
									<br />
									
									<?php	//$remove_html = strip_tags($msg_data_sms);	?>		 
																			
										<span id="sms-<?php echo $msg_data["id"]; ?>">
											<input type="hidden" id="likes-<?php echo $msg_data["id"]; ?>" value="<?php echo $msg_data["likes"]; ?>">
												<?php
													$query ="SELECT * FROM like_ipaddress WHERE sms_id = '" . $msg_data["id"] . "' and ip_address = '" . $ip_address . "'";
													$count = $db_handle->numRows($query);
													$str_like = "like";
													if(!empty($count)) 
													{
														$str_like = "unlike";
													}
												?>
																
												<span class="btn-likes">
													<input type="button" title="<?php echo ucwords($str_like); ?>" class="<?php echo $str_like; ?>" onClick="addLikes(<?php echo $msg_data["id"]; ?>,'<?php echo $str_like; ?>')" />
												</span>
																
										</span>
											-
										<button data-tooltip-id="1" data-title="Message Copied" class="btn btn-link trigger" aria-label="<?php echo $msg_data_br_to_n_add_line."www.dailysmsmaza.com"; ?>"> 
											Copy  
										</button> 
									
										<br />
										
										<span class="text-warning"> 
											Tags : 
										</span> 
													
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
													
										<a href="<?php echo $url."/sms"."/".$category_cat_id."/".$category_cat_re_name."/page/1"; ?>"> 
											<?php echo $category_cat_name; ?> 
										</a> , 
													
										<?php
												}
													
											}
										?>
							 </center> 
						</ul>                                         
					</div>
					
					<?php
								}
							}
					 
						}
					}
					else
					{
						?>
						<ul class="w3-ul w3-card-4">
							<div class="alert alert-danger">
								<center>
									<strong>Sorry ! </strong> No SMS Found..
								</center>
							</div>
					</ul>
					<?php
					}
					?>
 
  		 <center> 
 			 <?php echo $pagination; ?>   
 		 </center>
		 
       </div>
    
	</div>

	<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
	</div>
		
		
	<?php 
		
		include("Tags.php"); 
	
		include("Back_&_Bottom_to_Top_Jquery.php"); 
		
		include_once("footer.php"); 
		
	?>

</body>
</html>