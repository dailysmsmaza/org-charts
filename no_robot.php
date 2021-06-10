<html>

<head>
	<meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">

	<script type="text/javascript">
		function confirmation(url, s_page, e_page, num_msgs) {
			var flag = confirm("This category is already in DB. Are you sure?");
			if (flag)
				window.location.href = "https://localhost/dailyenglishquotes/no_robot.php?submit=submit&allowed=true&url=" + url + "&s_pg=" + s_page + "&e_pg=" + e_page + "&num_msgs=" + num_msgs;
			else
				window.location.href = "https://localhost/dailyenglishquotes/no_robot.php";
		}

		function alertDialog() {
			var flag = alert("This category is already in DB. Are you sure?");
		}
	</script>
</head>

<body>
	<form method="get">
		URL: <input type="text" name="url"><br>
		Start Page: <input type="text" name="s_pg"><br>
		End Page: <input type="text" name="e_pg"><br>
		Number of Message: <input type="text" name="num_msgs"><br>
		Author Name(Optional): <input type="text" name="aut_nm"><br>
		<input type="hidden" name="allowed" value="false"><br>
		<input type="submit" name="submit">
	</form>
</body>

</html>

<?php

if (isset($_GET["submit"])) {

	define("DEBUG", "debug");
	define("PRODUCTION", "production");
	define("CURRENT_MODE", DEBUG);

	require("connect.php");
	include('Emoji.class.php');

	set_time_limit(0);

	$url = $_GET["url"];
	$start_page = $_GET["s_pg"];
	$end_page = $_GET["e_pg"];

	$per_page_msg = $_GET["num_msgs"];

	$is_allowed = $_GET["allowed"];

	mysqli_query($c, "SET NAMES 'utf8'");
	mysqli_set_charset($c, "utf8");

	for ($i = $start_page; $i <= $end_page; $i++) {
		//$content = file_get_contents("http://www.freshsms.in/sms/lang/A/type/latest/page/".$i);

		$content = file_get_contents($url . "?p=" . $i);
		for ($j = 1; $j <= $per_page_msg; $j++) {


			$first_step = explode('<div class="author">', $content);
			if (!empty($first_step[$j])) {

				$second_step = explode("</div>", $first_step[$j]);
				$f = explode('<p>', $content);
				$s = explode("</p>", $f[$j]);
				$sms = strip_tags($s[0]);

				if (isset($_GET["aut_nm"]) && !empty($_GET["aut_nm"])) {
					$author = $_GET["aut_nm"];
				} else {
					$author = strip_tags($second_step[0]) . " Quotes";
					$author = str_replace(array("\n"), "", $author);
				}

				//echo $j . " " . $author . "</br>";
				// echo $author;
				$check_author_query = mysqli_query($c, "select * from category where cat_name='" . $author . "'") or die(mysqli_error($c));
				$check_author_query_count = mysqli_num_rows($check_author_query);

				if ($check_author_query_count > 0 and !!$is_allowed) {

					echo "<script type='text/javascript'>confirmation('$url', '$start_page', '$end_page', '$per_page_msg');</script>";

					break;
				} else {

					$tags = strip_tags($second_step[1]);

					$cat_names = $author . "," . $tags;

					$default_nm = mysqli_query($c, "select * from default_id where id=1");
					while ($default_nm_data = mysqli_fetch_array($default_nm)) {
						$default_nm_pid = $default_nm_data["pid"];
					}

					$default_pid = mysqli_query($c, "select * from default_id where id=2");
					while ($default_pid_data = mysqli_fetch_array($default_pid)) {
						$default_pid_pid = $default_pid_data["pid"];
					}


					$status_value = "Deactive";
					$date = strtotime("now");

					//$sms = str_replace(array("\r\n", "\r", "\n"), "<br />", $sms); 
					$sms = trim($sms);
					$sms = Emoji::emoji_to_html($sms);
					$sms = str_replace(array("<div></div>"), "", $sms);
					$sms = str_replace(array("<br>"), "<br/>", $sms);
					$sms = mysqli_real_escape_string($c, $sms);


					//echo "\n\n\n\n".$sms; 
					//echo "<br> Page: ".$i." Sms: ".$j;
					$cat_name_exp = explode(",", $cat_names);
					$cat_count = count($cat_name_exp);

					//print_r($cat_name_exp);
					for ($k = 0; $k < $cat_count - 1; $k++) {

						$cat_name = $cat_name_exp[$k];
						if ($k != 0) {
							$cat_name = $cat_name . " Quotes";
						}
						$cat_name = trim(preg_replace('/\t+/', '', $cat_name));
						$cat_name = mysqli_real_escape_string($c, $cat_name);

						$category = mysqli_query($c, "select * from category where cat_name='" . $cat_name . "'") or die(mysqli_error($c));
						echo $category_count = mysqli_num_rows($category);

						if ($category_count >= 1) {
							while ($category_data = mysqli_fetch_array($category)) {
								$cat_id[] = $category_data["cat_id"];
							}
						} else {
							$p_id = 0;
							if ($k == 0) {
								$p_id = 224;
							} else {
								$p_id = 225;
							}
							$cat_insert = mysqli_query($c, "insert into category(`cat_name`,`cat_title`,`status`,`p_id`)values('$cat_name','$cat_name','$status_value', '$p_id')") or die(mysqli_error($c));
							if (mysqli_query($c, $cat_insert)); {
								$last_cat_id = mysqli_insert_id($c);
								$cat_sub_insert = mysqli_query($c, "insert into category_sub (`cat_id`,`cat_name`,`cat_order`,`p_id`)values('$last_cat_id','$cat_name','$last_cat_id', '$p_id')") or die(mysqli_error($c));
							}
							$category = mysqli_query($c, "select * from category where cat_name='$cat_name'") or die(mysqli_error($c));
							while ($category_data = mysqli_fetch_array($category)) {
								$cat_id[] = $category_data['cat_id'];
							}
						}
					}


					$username = $default_nm_pid;

					$user = mysqli_query($c, "select * from user where username='$username'") or die(mysqli_error($c));
					$user_count = mysqli_num_rows($user);
					if ($user_count >= 1) {
					} else {
						$user_insert = mysqli_query($c, "insert into user (username) values ('$username')") or die(mysqli_error($c));
					}

					$user_info = mysqli_query($c, "select * from user where username='$username'") or die(mysqli_error($c));

					while ($user_data = mysqli_fetch_array($user_info)) {
						$user_id = $user_data["user_id"];
						$user_name = $user_data["username"];
					}

					mysqli_query($c, "SET NAMES 'utf8'");
					mysqli_set_charset($c, "utf8");

					$msg_insert = mysqli_query($c, "insert into message(sms,date,status,user_id) VALUES ('$sms','$date','$status_value','$user_id')") or die(mysqli_error($c));

					$sms_id = mysqli_insert_id($c);

					foreach ($cat_id as $sms_sub_cat_id) {

						$cat_sms = mysqli_query($c, "update category set all_sms = all_sms + 1 where cat_id='$sms_sub_cat_id'");

						$sms_sub_insert = mysqli_query($c, "insert into message_sub
								(sms_id,cat_id)values('$sms_id','$sms_sub_cat_id')");
					}

					$cat_names = [];
					$cat_name_exp = [];
					$cat_id = [];

					header("Location: https://localhost/dailyenglishquotes/no_robot.php");
					die();
				}
			}
		}
	}

	echo "<br> Execution Complete";
}
?>