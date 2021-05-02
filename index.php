<?php
require_once('createEmoji.php');

include("header.php");
require("connect.php");
include("names.php");


require_once("createDBController.php");

require_once("get_sub_categories.php");

$ip_address = $_SERVER['REMOTE_ADDR'];

$adDisplay = 0;


// $all_sub_categories = array();

// function set_categories($c, $pId, $all_sub_categories)
// {
// 	$categories = mysqli_query($c, "select * from category where p_id=$pId");
// 	while ($categories_data = mysqli_fetch_array($categories)) {
// 		$cat_id = $categories_data["cat_id"];
// 		$all_sub_categories[] = $cat_id;
// 		set_categories($c, $cat_id, $all_sub_categories);
// 	}
// }

?>

<!DOCTYPE html>
<html>

<head>

	<link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
	<link href="<?php echo $url; ?>//style.css" rel="stylesheet">

	<title> <?php echo $title; ?> : Free Special Whatsapp Funny Jokes SMS </title>

	<meta name="robots" content="index,follow">
	<meta name="title" content="<?php echo $title; ?> : Free Special Whatsapp Funny Jokes SMS">
	<meta name="keywords" content="Jokes, Sms, Hindi, English, Gujarati, Funny, Top, Latest, Daily, New, 2017, Messages, Shayari, Sad, Love, Romantic, Bf-Gf  :: <?php echo $title; ?>">
	<meta name="description" content="Latest Collection 2017, New Sms, Funny Sms, Free Whatsapp Sms, Jokes Sms, Top Sms, Fresh Sms, Sad-Love Sms, Wishes Sms,  Year Sms, Funbull Sms, Shayari Sms, Romantic Sms, Bf-Gf Sms :: <?php echo $title; ?>">

	<!-- <meta name="yandex-verification" content="bb647c0ade98d9a5" /> -->

	<!-- <script type="text/javascript" language="javascript">
      var aax_size='728x90';
      var aax_pubname = 'dailymaza-21';
      var aax_src='302';
    </script> -->
	<!-- <script type="text/javascript" language="javascript" src="http://c.amazon-adsystem.com/aax2/assoc.js"></script> -->

	<script>
		function addLikes(id, action) {
			$.ajax({
				url: "<?php echo $url; ?>/add_likes.php",
				data: 'id=' + id + '&action=' + action,
				type: "POST",
				beforeSend: function() {
					$('#sms-' + id + ' .btn-likes').html("<img src='<?php echo $url; ?>/images/LoaderIcon.gif' />");
				},
				success: function(data) {
					var likes = parseInt($('#likes-' + id).val());
					switch (action) {
						case "like":
							$('#sms-' + id + ' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes(' + id + ',\'unlike\')" />');
							likes = likes + 1;
							break;
						case "unlike":
							$('#sms-' + id + ' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes(' + id + ',\'like\')" />')
							likes = likes - 1;
							break;
					}
					$('#likes-' + id).val(likes);
					if (likes > 0) {
						$('#sms-' + id + ' .label-likes').html(likes + " Like(s)");
					} else {
						$('#sms-' + id + ' .label-likes').html('');
					}
				}
			});
		}
	</script>

	<base href="/">

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6376552725660392",
			enable_page_level_ads: true
		});
	</script>

</head>

<body>

	<?php include_once("analyticstracking.php"); ?>
	<?php include_once("dist/copy_sms.php"); ?>


	<script src="dist/clipboard.min.js"></script>

	<div class="visible-md visible-sm visible-xs">

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#smsby">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"> SMS By : </a>
				</div>
				<div>
					<div class="collapse navbar-collapse" id="smsby">
						<ul class="nav navbar-nav navbar-right">

							<li> <a href="<?php echo $url; ?>/last/updated/sms/new2old/page/1" class="list-group-item"> Last / Latest Updated Sms </a> </li>
							<li> <a href="<?php echo $url; ?>/popular/most/sms/new2old/page/1" class="list-group-item"> Popular Sms </a> </li>
							<li> <a href="<?php echo $url; ?>/top/user/page/1" class="list-group-item"> Top User </a> </li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>


	<?php include("category_menu_pc.php"); ?>


	<div class="col-sm-6">
		<ul class="w3-ul w3-card-4">
			<li class="w3-cyan">
				<center> Last / Latest Updated SMS </center>
			</li>
		</ul>

		<?php


		$adjacents = 2;
		$targetpage = $url . "/last/updated/sms/new2old/page";

		$default_limit = mysqli_query($c, "select * from default_id where id=2");
		$default_limit_pid = mysqli_fetch_row($default_limit);
		$limit = $default_limit_pid[2];

		/*$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='$ip_address'");
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
		}*/

		/*if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
		{
			$pages_query = mysqli_query($c,"select count(id) from message where lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."' AND status='Active' order by id desc");
		}
		else
		{
			$pages_query = mysqli_query($c,"select count(id) from message where status='Active' order by id desc");
		}
		*/


		$root_category = 185;

		set_categories($c, $root_category, $all_sub_categories);

		$ids = join("','", $all_sub_categories);

		$pages_query = mysqli_query($c, "select count(id) from message_sub where cat_id IN('$ids') order by id desc");

		$pages_row = mysqli_fetch_row($pages_query);
		$total_records = $pages_row[0];

		include("paging.php");


		/*if(!empty($english) OR !empty($hindi) OR !empty($gujarati))
		{
			$msg = mysqli_query($c,"select * from message where status='Active' AND lang='".$language."' OR lang='".$hindi."' OR lang='".$gujarati."' order by id desc LIMIT $start,$limit");
		}
		else
		{
			$msg = mysqli_query($c,"select * from message where status='Active' order by id desc LIMIT $start,$limit");
		}*/

		$sub_message = mysqli_query($c, "select * from message_sub where cat_id IN('$ids') order by id desc LIMIT $start,$limit");
		while ($sub_message_data = mysqli_fetch_array($sub_message)) {

			$sub_message_sms_id = $sub_message_data["sms_id"];

			$msg = mysqli_query($c, "select * from message where id='" . $sub_message_sms_id . "'");

			while ($msg_data = mysqli_fetch_array($msg)) {
				/*if($adDisplay%3==0 && $adDisplay!=0){
				?>
				<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.photorecoverypro" target="_blank">
								<img class="img-responsive" src="http://www.dailysmsmaza.com/images/photo_recovery_pro.png" alt="Photo Recovery Pro (Restore Deleted Photos)"> 
				</a>
				<?php
							// echo "adDisplay: "+$adDisplay;
				// echo include(dirname(__FILE__).'/pa_antiadblock_2481496.php');
					// echo include_once (dirname(__FILE__) . '/pa_antiadblock_2481496.php');
			}*/

				$msg_data_sms = $msg_data["sms"];
				$msg_data_user_id = $msg_data["user_id"];
				$msg_data_id = $msg_data["id"];
				$msg_data_likes = $msg_data["likes"];

				include("date.php");

				$user = mysqli_query($c, "select * from user where user_id=$msg_data_user_id");
				while ($user_data = mysqli_fetch_array($user)) {
					$user_id = $user_data["user_id"];
					$user_name = $user_data["username"];

		?>

					<?php include("sms_content.php"); ?>

		<?php
				}

				$adDisplay++;
			}
		}
		?>

		<center>
			<!--<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" target="_blank">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/mathematics_puzzle.jpg" alt="Mathemateics Puzzle (Mathemateics Quiz)"> 
			</a>-->

			<!--<a target="_blank"  
			href="https://www.amazon.in/gp/product/B086CSGV2N/ref=as_li_tl?ie=UTF8&camp=3638&creative=24630&creativeASIN=B086CSGV2N&linkCode=as2&tag=sahilhamira02-21&linkId=2b46c5d00c8d610831efe78ffa6a0dfa"><img border="0" src="//ws-in.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=IN&ASIN=B086CSGV2N&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL160_&tag=sahilhamira02-21" >
			<img src="//ir-in.amazon-adsystem.com/e/ir?t=sahilhamira02-21&l=am2&o=31&a=B086CSGV2N" 
			width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
			</a>-->


			<?php

			echo $pagination;
			?>


		</center>

	</div>




	<!--<div class="col-sm-2">
		<?php include("user_lang.php"); ?>
	</div>-->


	<?php


	require_once("customFunction.php");

	include("Tags.php");

	include_once("Back_&_Bottom_to_Top_Jquery.php");

	include_once("footer.php");

	?>

</body>

</html>