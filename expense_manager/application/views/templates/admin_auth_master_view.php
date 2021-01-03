<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title> Welcome to
		     <?php echo $setting->site_project_name; ?> Admin | <?php echo $page_title; ?>
	</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
			sessionStorage.fonts = true;
		}
		});
		</script>
		<!--end::Web font -->
		<!--begin::Base Styles -->
		<?php
		$css = array( 'style.bundle.css','vendors.bundle.css');
		echo get_css($css,'admin_css');
		?>
		<!--end::Base Styles -->
		 <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>images/favicon.ico">
	</head>
	<!-- end::Head -->
	<!-- end::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--singin" id="m_login">
				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
					<div class="m-stack m-stack--hor m-stack--desktop">
						<div class="m-stack__item m-stack__item--fluid">
							<?php echo $view_content; ?>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(<?php echo base_url('assets/admin/images/bg-4.jpg'); ?>)">
					<div class="m-grid__item m-grid__item--middle">
						<!--<h3 class="m-login__welcome">
						Join Our Community
						</h3>
						<p class="m-login__msg">
							Lorem ipsum dolor sit amet, coectetuer adipiscing
							<br>
							elit sed diam nonummy et nibh euismod
						</p>-->
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
		<!--begin::Base Scripts -->
		<?php
		$js = array('vendors.bundle.js','scripts.bundle.js');
		echo get_js($js,'admin_js');
		echo get_js('custom.js','admin_custom_js');
		?>
		<!--end::Base Scripts -->
	</body>
	<!-- end::Body -->
</html>