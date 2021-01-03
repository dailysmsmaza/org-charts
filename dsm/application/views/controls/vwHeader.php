<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Welcome to Artbeat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>images/favicon.ico">
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/tether.min.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/bootstrap.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/slick.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/style.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/responsive.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>css/custom.css" />
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/jquery-3.1.1.min.js" ></script>
            <script language="javascript" type="text/javascript"  src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.js"></script>
            <script>var base_url = "<?php echo base_url(); ?>"</script>
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/tether.min.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/bootstrap.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/slick.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/common.js" ></script>
            <script language="javascript" type="text/javascript" src="<?php echo HTTP_ASSETS_PATH_CLIENT; ?>js/custom.js" ></script>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <?php
            $jsname = "";
            if (($this->router->fetch_class() === 'showcase')) {
                $jsname = "showcase.js";
            }else if (($this->router->fetch_class() === 'contact_us')) {
                $jsname = "contact-us.js";
            }
            ?>
            <? if ($jsname != "") { ?>
                <script language="javascript" type="text/javascript" src="<? echo HTTP_ASSETS_PATH_CLIENT; ?>js/<?= $jsname ?>"></script>
            <? } ?>
    </head>
    <body class="home">
        <header>
            <section class="header-med">
                <figure class="logo"> <a href="<?php echo base_url('home'); ?>"><img src="<?php echo base_url($websetting->website_frontend_logo); ?>" alt="<?php echo $websetting->website_frontend_logo_caption; ?>"/></a> </figure>
                <section class="main-menu">
                    <section class="container">
                        <nav> <a class="responsive-menu" href="javascript:;"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></a>
                            <aside class="menu-wrapper">
                                <ul class="menu">
                                    <li <?php echo ($this->router->fetch_class() === 'home' || $this->router->fetch_class() === 'terms_condition') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('home'); ?>">Home</a></li>
                                    <li <?php echo ($this->router->fetch_class() === 'about_us') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                                    <li <?php echo ($this->router->fetch_class() === 'services') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('services'); ?>">Services</a></li>
                                    <li <?php echo ($this->router->fetch_class() === 'showcase') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('showcase'); ?>">Showcase</a></li>
                                    <li <?php echo ($this->router->fetch_class() === 'contact_us') ? 'class="active"' : ''; ?>><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                                </ul>
                            </aside>
                        </nav></section>
                </section>
            </section>
        </header>
        <section class="wrapper">