<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="<?php echo base_url('assets/setting/').get_themeoption('favicon');?>">
  <title><?php echo $page_title ?></title>
  <link href="<?php echo base_url('assets/front/') ?>css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/') ?>css/fontawesome.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/') ?>css/style.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/') ?>css/responsive.css" rel="stylesheet">
</head>
<body>
  <div class="menu-ovelay"></div>
<!-- header start -->
<header class="header">
  <div class="container">
      <div class="row">
          <div class="col-3 brand-wrap">
              <a href="<?php echo base_url() ?>">
                <img src="<?php  echo (get_themeoption('logo')!="") ?  base_url('assets/setting/').get_themeoption('logo') : base_url('assets/images/logo.png');?>" alt="" />            
            </a>
          </div>
          <div class="col-9 topright">
              <div class="navigation">
                  <div id="cssmenu">
                    <ul>
                      <li class="active"><a href="<?=base_url();?>">About Us</a></li>                     
                      <li><a href="<?=base_url('contact');?>">Contact Us</a></li>
                    </ul>
                  </div>
              </div>
              <div class="loginbtn">
                  <a href="<?php echo base_url('login') ?>">
                    <span class="icon"><img src="<?php echo base_url('assets/') ?>images/lock.png" alt="" /></span>
                    <span class="logintext">Sign In</span>
                  </a>
              </div>
              <div class="topdemobtn">
                  <a href="<?php echo base_url('signup') ?>">Sign UP</a>
              </div>
          </div>
      </div>
  </div>
</header>
<!-- header over --> 