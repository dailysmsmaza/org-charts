<?php
require_once('createEmoji.php');

include("header.php");
require_once("connect.php");
require_once("names.php");

require_once("createDBController.php");
require_once("get_sub_categories.php");

$ip_address = $_SERVER['REMOTE_ADDR'];
	
$adDisplay = 0;

?>

<!DOCTYPE html>
<html>

<head>

	<title> Last / Latest Updated SMS : <?php echo $title; ?> </title>

	<meta name="robots" content="index,follow">
	<meta name="title" content="Popular SMS : <?php echo $title; ?>">
	<meta name="keywords" content="Latest jokes sms or messages, all time new sms, users liked new, most usable or viewable sms :: <?php echo $title; ?>">
	<meta name="description" content="Latest jokes sms which is last uploaded by the user to see in top most in Latest page :: <?php echo $title; ?>">



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


	<script>
		$(function() {

			$(document).on('click', '.trigger', function() {
				$(this).addClass("on");
				$(this).tooltip({
					items: '.trigger.on',
					position: {
						my: "left+30 center",
						at: "right center",
						collision: "flip"
					},
					delay: 1000
				});
				$(this).trigger('mouseenter');
			});
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
			<li class="w3-cyan">
				<center> Last / Latest Updated Sms </center>
			</li>
		</ul>

		<?php

		$adjacents = 2;

		$targetpage = $url . "/last/updated/sms/new2old/page";

		$default_limit = mysqli_query($c, "select * from default_id where id=2");
		$default_limit_pid = mysqli_fetch_row($default_limit);
		$limit = $default_limit_pid[2];

		$default_limit = mysqli_query($c, "select * from default_id where id=4");
		$default_limit_pid = mysqli_fetch_row($default_limit);
		$msg_limit = $default_limit_pid[2];

		/*$get_lang = mysqli_query($c,"select * from lang_ipaddress where ip_address='".$ip_address."'");
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
				}*/

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
					$msg = mysqli_query($c,"select * from message where status='Active' order by id desc LIMIT
					$start,$limit");

				}*/

		$sub_message = mysqli_query($c, "select * from message_sub where cat_id IN('$ids') LIMIT $start,$limit order by id desc");
		while ($sub_message_data = mysqli_fetch_array($sub_message)) {

			$sub_message_sms_id = $sub_message_data["sms_id"];

			$msg = mysqli_query($c, "select * from message where id='" . $sub_message_sms_id . "'");

			while ($msg_data = mysqli_fetch_array($msg)) {
				/*if($adDisplay%3==0 && $adDisplay!=0){
						// echo "adDisplay: "+$adDisplay;
						?>
						<a href="https://play.google.com/store/apps/details?id=com.madhavgames.kiteflying">
							<img class="img-responsive" src="http://www.dailysmsmaza.com/images/download_now.png" alt="Music + Ringtone Folder Player"> 
						</a>
						<?php
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
			<a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" target="_blank">
				<img class="img-responsive" src="http://www.dailysmsmaza.com/images/mathematics_puzzle.jpg" alt="Mathemateics Puzzle (Mathemateics Quiz)">
			</a>
			<?php echo $pagination;	?>
		</center>
	</div>

	<!--<div class="col-sm-2">
			<?php include("user_lang.php"); ?>
	</div>-->





	<!-- <a href="javascript:void(0);" id="share" title="Scroll to Top"></a> -->

</body>

</html>