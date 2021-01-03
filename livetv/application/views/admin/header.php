<!doctype html>
<html>
<head>

<link href="<?php echo base_url('css/admin/style.css'); ?>" rel="stylesheet">

<title> <?php echo TITLE; ?> Admin Panel</title>
</head>

<body>

<div class="top">
		<div class="logo">
			<div class="left"> <?php echo TITLE; ?> Admin Panel </div>
		</div>

 <div class="end">
	<ul id="qm0" class="qmmc">
		<li><a class="qmparent" href="<?php echo base_url('admin/main/home'); ?>">Home</a> </li>
        <li><a class="qmparent" href="Advertise.php"> Advertisement </a></li>
		<li><a class="qmparent">Admin</a>
	  		<ul>
				<li><a href="">Edit Admin Profie</a></li>
        		<li><a class="qmparent" href="">Logout</a></li>
	  		</ul>
		</li>
	</ul>
</div>

</div>

</body>
</html>


