<?php 
 /* Get Segment*/
	$current_segment = $this->uri->segment(1); 
	$secnond_segment = $this->uri->segment(2);
	$role =  $this->session->userdata('role');
	$access_level =  $this->session->userdata('access_level');
	if($role==2 && $access_level==2){
         $userid =  $this->session->userdata('id');
    }elseif ($role==3 && $access_level==2) {
    	 $userid =  $this->session->userdata('company');
    }elseif ($role==3 && $access_level==1) {
    	 $userid =  $this->session->userdata('company');
    }elseif ($role==3 && $access_level==0) {
    	 $userid =  $this->session->userdata('company');
    }else{
	     $userid =  $this->session->userdata('id');
	}
	$username = ''; $num = 0;
	if($userid){
		$username = get_userinfo($userid, 'user_name', 'id');
	    $username = ($username)?$username['user_name']:'';

	    $query =  $this->db->query('SELECT * FROM employee_short WHERE company_id = '.$userid);
	    
	    $num = $query->num_rows();
	}
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta name="description" content=""> -->
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url('assets/setting/').get_themeoption('favicon');?>">
	<title><?php echo $page_title; ?></title>
	<link href="<?php echo base_url('assets/') ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/') ?>css/fontawesome.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/') ?>css/style.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/') ?>css/responsive.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/') ?>css/tokenize2.css" rel="stylesheet">
	<script src="<?php echo base_url('assets/') ?>js/jquery-3.2.1.min.js"></script> 
</head>
<body>
<!-- header start -->
<div class="mainheader">
<div class="logousersec maincontainer">
<div class="logosec">
	<a href="<?php echo base_url('login/dashboard') ?>"><img src="<?php  echo (get_themeoption('logo')!="") ?  base_url('assets/setting/').get_themeoption('logo') : base_url('assets/images/logo.png');?>" alt="" /></a>
</div>
<div class="menuicon smootheffect"><i class="fa fa-bars"></i></div>
<div class="topusersec">
<?php
	if ($this->session->userdata("id") != '') { ?>
	        	     <div class="dropdown tools-item clsuserdetail">
                      <a href="#" class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php $userimg= get_anycolunm("user_master","user_image",$this->session->userdata("id")); 
								$ckhimage = ($userimg)?'assets/userimage/'.$userimg:'assets/images/user-profile.jpg';
								//$fnlusrimg = base_url().$ckhimage;
								?>
								<img src="<?php  echo base_url($ckhimage);?>" alt="<?php echo get_anycolunm("user_master","first_name",$this->session->userdata("id")); ?>" />
							</a>         
	                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
	                           <a class="dropdown-item" href="<?php echo base_url('login/user_profile/'.$this->session->userdata("id")); ?>"><i class="fa fa-user"></i> Profile</a>
	                           <a class="dropdown-item" href="<?php echo base_url("login/logout") ?>"><i class="fa fa-power-off"></i> Logout</a>

	                       </div>
                   </div>
			<?php } ?>
</div>
</div>
<div class="topnavbar maincontainer">
<ul>
		<li class="<?php echo  ($secnond_segment == 'dashboard') ? 'active' : '' ?>"><a href="<?php echo base_url("login/dashboard") ?>"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
		<?php 
			if(get_useraccess($this->session->userdata("id")) == 3){
		?>
			<li class="<?php echo ($current_segment == 'user') ? 'active' : '' ?>"><a href="<?php echo base_url("user") ?>"><i class="fa fa-user"></i>User List</a></li>
			<li class="<?php echo ($current_segment == 'company') ? 'active' : '' ?>"><a href="<?php echo base_url("company") ?>"><i class="fa fa-list-ul"></i>Company List</a></li>
			
			<?php 
				if($secnond_segment == "landing_page"){
					$current_segment =  "";
				}
			 ?>
			<li class="<?php echo ($current_segment == 'testimonial') ? 'active' : '' ?>"><a href="<?php echo base_url("testimonial") ?>"><i class="fa fa-quote-left"></i>Testimonial List</a></li>
			<li class="<?php echo ($secnond_segment == 'landing_page') ? 'active' : '' ?>"><a href="<?php echo base_url("setting/landing_page") ?>"><i class="fa fa-file"></i>Landing Page</a></li>
			<li class="<?php echo ($current_segment == 'setting') ? 'active' : '' ?>"><a href="<?php echo base_url("setting") ?>"><i class="fa fa-cog"></i>Setting</a></li>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-comments-o"></i>All Feedback</a></li>
			<?php /*?><li class="<?php echo ($current_segment == 'setting') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-comments-o"></i>Received Feedback</a></li><?php */?>
		<?php }
			//if(get_userrole($this->session->userdata("id")) == 2){
		if(get_useraccess($this->session->userdata("id")) == 2){
		?>
			<li class="<?php echo ($current_segment == 'department') ? 'active' : '' ?>"><a href="<?php echo base_url("department") ?>"><i class="fa fa-users"></i>Team</a></li>
			<li class="<?php echo ($current_segment == 'employee') ? 'active' : '' ?>"><a href="<?php echo base_url("employee") ?>"><i class="fa fa-user"></i>Employee</a></li>
			<?php
			
			if( ($role == 2 && $access_level==2 && $username && $num) || ($role == 3 && $access_level == 2 && $username && $num)  ){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-o"></i>Received Feedback</a></li>
		<?php }
			//if(get_userrole($this->session->userdata("id")) == 2){
		if(get_useraccess($this->session->userdata("id")) == 1){
		?>
			<li class="<?php echo ($current_segment == 'department') ? 'active' : '' ?>"><a href="<?php echo base_url("department") ?>"><i class="fa fa-users"></i>Team</a></li>
			<?php
			if($role == 3 && $access_level==1 && $username && $num){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-o"></i>Received Feedback</a></li>
		<?php } 
		//if(get_userrole($this->session->userdata("id")) == 3){
		if(get_useraccess($this->session->userdata("id")) == 0){
			?>
			<?php
			if($role == 3 && $access_level==0 && $username && $num){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'setting') ? 'givefeedback' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-o"></i>Received Feedback</a></li>
			<?php
		}
		?>
								
		
	</ul>
</div>
</div>
<div class="header desktopsecnone">
		<div class="header-content smootheffect">
			<div class="brandlogo smootheffect ">
					<a href="<?php echo base_url('login/dashboard') ?>"><img src="<?php  echo (get_themeoption('logo')!="") ?  base_url('assets/setting/').get_themeoption('logo') : base_url('assets/images/logo.png');?>" alt="" /></a>
			</div>
			<!-- <div class="menuicon smootheffect"><i class="fa fa-bars"></i></div> -->
			<div class="userinfo">
					<span>Welcome&nbsp;&nbsp;</span><a href="<?php echo base_url('login/user_profile/'.$this->session->userdata("id")); ?>"> <?php echo get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")); ?></a>
			</div> 
		</div>
</div>
<!-- header close -->
<!-- sidebar start -->
<div class="sidebar smootheffect desktopsecnone">
	<ul>
		<li class="<?php echo  ($secnond_segment == 'dashboard') ? 'active' : '' ?>"><a href="<?php echo base_url("login/dashboard") ?>"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
		<?php 
			if(get_useraccess($this->session->userdata("id")) == 3){
		?>
			<li class="<?php echo ($current_segment == 'user') ? 'active' : '' ?>"><a href="<?php echo base_url("user") ?>"><i class="fa fa-user"></i>User List</a></li>
			<li class="<?php echo ($current_segment == 'company') ? 'active' : '' ?>"><a href="<?php echo base_url("company") ?>"><i class="fa fa-list-ul"></i>Company List</a></li>
			
			<?php 
				if($secnond_segment == "landing_page"){
					$current_segment =  "";
				}
			 ?>
			<li class="<?php echo ($current_segment == 'testimonial') ? 'active' : '' ?>"><a href="<?php echo base_url("testimonial") ?>"><i class="fa fa-quote-left"></i>Testimonial List</a></li>
			<li class="<?php echo ($secnond_segment == 'landing_page') ? 'active' : '' ?>"><a href="<?php echo base_url("setting/landing_page") ?>"><i class="fa fa-file"></i>Landing Page</a></li>
			<li class="<?php echo ($current_segment == 'setting') ? 'active' : '' ?>"><a href="<?php echo base_url("setting") ?>"><i class="fa fa-cog"></i>Setting</a></li>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-comments-o"></i>All Feedback</a></li>
			<?php /*?><li class="<?php echo ($current_segment == 'setting') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-comments-o"></i>Received Feedback</a></li><?php */?>
		<?php }
			//if(get_userrole($this->session->userdata("id")) == 2){
		if(get_useraccess($this->session->userdata("id")) == 2){
		?>
			<li class="<?php echo ($current_segment == 'department') ? 'active' : '' ?>"><a href="<?php echo base_url("department") ?>"><i class="fa fa-users"></i>Team</a></li>
			<li class="<?php echo ($current_segment == 'employee') ? 'active' : '' ?>"><a href="<?php echo base_url("employee") ?>"><i class="fa fa-user"></i>Employee</a></li>
			<?php
			
			if( ($role == 2 && $access_level==2 && $username && $num) || ($role == 3 && $access_level == 2 && $username && $num)  ){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-open"></i>Received Feedback</a></li>
		<?php }
			//if(get_userrole($this->session->userdata("id")) == 2){
		if(get_useraccess($this->session->userdata("id")) == 1){
		?>
			<li class="<?php echo ($current_segment == 'department') ? 'active' : '' ?>"><a href="<?php echo base_url("department") ?>"><i class="fa fa-users"></i>Team</a></li>
			<?php
			if($role == 3 && $access_level==1 && $username && $num){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-open"></i>Received Feedback</a></li>
		<?php } 
		//if(get_userrole($this->session->userdata("id")) == 3){
		if(get_useraccess($this->session->userdata("id")) == 0){
			?>
			<?php
			if($role == 3 && $access_level==0 && $username && $num){ ?>
			    <li><a href="<?php echo base_url($username) ?>" target="_blank"><i class="fa fa-bar-chart"></i>Org Chart</a></li><?php
			} ?>
			<li class="<?php echo ($current_segment == 'requestfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("requestfeedback") ?>"><i class="fa fa-comment"></i>Request Feedback</a></li>
			<li class="<?php echo ($current_segment == 'givefeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback") ?>"><i class="fa fa-commenting-o"></i>Give Feedback</a></li>
			<li class="<?php echo ($current_segment == 'receviedfeedback') ? 'active' : '' ?>" ><a href="<?php echo base_url("givefeedback/receviedfeedback") ?>"><i class="fa fa-envelope-open"></i>Received Feedback</a></li>
			<?php
		}
		?>
								
		<!-- <li><a href="<?php echo base_url("login/logout") ?>"><i class="fa fa-power-off"></i>Logout</a></li> -->
	</ul>
</div>
