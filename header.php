<?php
// ob_end_flush();
// ob_start();
// session_start();

include_once("names.php");

define("DEBUG", "debug");
define("PRODUCTION", "production");
define("CURRENT_MODE", DEBUG);

?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/bootstrap/w3.css">
    <link href="<?php echo $url; ?>/style.css" rel="stylesheet">

    <script src="<?php echo $url; ?>/bootstrap/jquery.min.js"></script>
    <script src="<?php echo $url; ?>/bootstrap/bootstrap.min.js"></script>
    <meta name="propeller" content="f1e6bf35efc28edac2049438a11d40ed">


    <script data-ad-client="ca-pub-5861328993701577" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- <script data-ad-client="ca-pub-5861328993701577" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->

    <!--     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6376552725660392",
    enable_page_level_ads: true
  });
</script>
 -->

    <!-- <script data-ad-client="ca-pub-4610357151191256" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-4610357151191256",
    enable_page_level_ads: true
  });
</script> -->

</head>

<body>

    <?php include_once("analyticstracking.php"); ?>

    <!-- <?php
            if (isset($_SESSION[$s_name])) {
                $username = $_SESSION[$s_name];
            ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo $url; ?>" class="navbar-brand"> <span class="glyphicon glyphicon-home"></span> &nbps; <?php echo $title; ?> </a>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-right">
                            <li> <a href="<?= $url ?>/account/check"><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?> </a> </li>
                            <li> <a href="<?= $url ?>/addsms/new"><span class="glyphicon glyphicon-file"></span> Add SMS </a> </li>
                            <li> <a href="<?= $url ?>/mysms/all/1"><span class="glyphicon glyphicon-file"></span> My SMS </a> </li>
                            <li> <a href="<?= $url ?>/logout"><span class="glyphicon glyphicon-off"></span> Logout </a> </li>
                            <li> <a href="<?= $url ?>/disclaimer"><span class="glyphicon glyphicon-book"></span> Disclaimer </a> </li>
                            <li> <a href="mailto:dailysmsmaza@gmail.com"><span class="glyphicon glyphicon-book"></span> Contact Us </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </nav>


    <?php
            } else {
    ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo $url; ?>" class="navbar-brand"><span class="glyphicon glyphicon-home"> </span> &nbsp; <?php echo $title; ?> </a>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-right">
                            <li> <a href="<?= $url ?>/login/getinfo"><span class="glyphicon glyphicon-log-in"></span> Log In </a> </li>
                            <li> <a href="<?= $url ?>/register/getinfo"> <span class="glyphicon glyphicon-user"></span> Register </a> </li>
                            <li> <a href="<?= $url ?>/disclaimerisc"><span class="glyphicon glyphicon-book"></span> Disclaimer </a> </li>
                            <li> <a href="mailto:dailysmsmaza@gmail.com"><span class="glyphicon glyphicon-book"></span> Contact Us </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </nav>

    <?php
            }
    ?> -->

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo $url; ?>" class="navbar-brand"><span class="glyphicon glyphicon-home"> </span> &nbsp; <?php echo $title; ?> </a>
            </div>
            <div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a href="<?= $url ?>/disclaimerisc"><span class="glyphicon glyphicon-book"></span> Disclaimer </a> </li>
                        <li> <a href="mailto:dailysmsmaza@gmail.com"><span class="glyphicon glyphicon-book"></span> Contact Us </a> </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </nav>

    <div class="container">
        <form class="navbar-form navbar-right" method="POST">
            <div class="input-group">
                <input type="text" name="search" placeholder="Search..." class="form-control" />
                <div class="input-group-btn">
                    <button class="btn btn-info">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!--
	<div class="visible-sm visible-xs">
		<center> 
		 <a href="https://play.google.com/store/apps/details?id=com.happytechsolution.mathematicspuzzle" target="_blank">
							<img src="http://www.dailysmsmaza.com/images/mathematics_puzzle.jpg" style="width:80%;height:120px;" alt="Mathemateics Puzzle (Mathemateics Quiz)"> 
			</a> 
 		 </center>
	</div>
	-->
    <div class="container visible-lg">
        <nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
                <!-- <li> <a href="<?php echo $url; ?>/last/updated/sms/new2old/page/1" class="list-group-item"> Last / Latest Updated Sms </a> </li> -->
                <!-- <li> <a href="<?php echo $url; ?>/popular/most/sms/new2old/page/1" class="list-group-item"> Popular Sms </a> </li> -->
                <!-- <li> <a href="<?php echo $url; ?>/top/user/page/1" class="list-group-item"> Top User </a> </li> -->
                <!-- <li> <a href="#" class="list-group-item"> Add Your Sms </a> </li> -->
            </ul>
        </nav>
    </div>

    <?php
    if (isset($_POST["search"])) {
        $search = $_POST["search"];
        header("location:$url/search/$search/page/1");
    }
    ?>

</body>

</html>