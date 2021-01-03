
	
	<html>
	
	<body>
		<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				  </button>
				<a class="navbar-brand" > <?php echo $title; ?> Admin Panel</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="<?=$adminurl?>/home.php?id=0">Home</a></li>
					<li class="active"><a href="default_menu.php">Default Menu</a></li>
					<li class="active"><a href="user_messages.php">User Message</a></li>
					<li class="active"><a href="Advertise.php">Advertisement</a></li>
					<li class="dropdown active">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="<?=$adminurl?>/adminchange.php">Edit Admin Profie</a></li>
						<li><a href="<?=$adminurl?>/logout.php">Logout</a></li>
					  </ul>
					</li>
				  </ul>
				</div>
			  </div>
		</nav>

	</body>
	
</html>