<html>
<head>

	<link rel="stylesheet" type="text/css" href="style.css" />

	<script>
		function go_createSiteMap()
		{
			$.ajax({
				url:'create_sitemap.php',
				type: "POST",
				success:function()
				{
					alert('SiteMap Created Successfully Created..!');
				},
				error:function()
				{
					alert('Error');
				}
			});
		}
	</script>
</head>

<body>

<?php

	session_start();
	include_once("names.php");
	
if(isset($_SESSION["username"]))
{
	
	?>
	
			
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="home.php?id=0">Admin</a>
          <div class="nav-collapse">
            <ul class="nav">
			  <li class="active"><a href="last.php">Last Updated SMS</a></li>
			  <li class="active"><a href="search_sms.php">Search SMS</a></li>
			  <li class="active"><a href="Lang.php">Change Language</a></li>
			  <li class="active"><a href="default_menu.php">Default Menu</a></li>
			  <li class="active"><a href="user_messages.php">User Messages</a></li>
			  <li class="active"><a href="keydesc.php"> ADD Key / Desc </a></li>
			   <li class="dropdown active">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">SiteMap <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li class="active"><a onclick="go_createSiteMap()">Create SiteMap</a></li>
					<li class="active"><a href="<?php echo $url; ?>/sitemap.xml">Display SiteMap</a></li>
				  </ul>
			  </li>
			  <li class="active"><a href="advertise.php">Advertise</a></li>
			  <li class="active"><a href="adminchange.php">Edit Profile</a></li>
			  <li class="active"><a href="logout.php">Logout</a></li>
			  
			 
			
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<?php
}
else
{
	header("location:$url");
}

?>

</body>
</html>