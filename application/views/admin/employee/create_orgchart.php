<?php
$role = $this->session->userdata('role');
$access_level=$this->session->userdata('access_level');
if($role==2 && $access_level==2){
  $companyid = $this->session->userdata("id");
}elseif ($role==3 && $access_level==2) {
  $companyid = $this->session->userdata("company");
}else{
   $companyid = $this->session->userdata("id");
} 
$usersq = $this->db->query("SELECT id,user_name FROM user_master WHERE CEO = 0 AND company = '".$companyid."'");
if($usersq->num_rows()){
  foreach ($usersq->result() as $user) {
    $query = $this->db->query("SELECT * FROM employee_short WHERE item_id = ".$user->id);
    $sort = $query->row();
    if($sort){}else{
      $data = array('company_id' => $companyid, 'item_id' => $user->id, 'parent_id' => 0, 'depth' => 1);
      $this->db->insert('employee_short', $data);
    }
  }
}

$ccheck = $this->db->query("SELECT id,user_name FROM user_master WHERE id = '".$companyid."'");
$crow = $ccheck->row();

$username = $crow->user_name; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?=$page_title;?></title>
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=base_url();?>/assets/chart/css/jquery.orgchart.css">
  <link rel="stylesheet" href="<?=base_url();?>/assets/chart/css/style.css">
  <link rel="stylesheet" href="<?=base_url();?>/assets/chart/css/sidebar.css">
</head>
<body>
<div class="chartbuttons">
  <div class="addbtn adduser"><a href="<?=base_url('employee'); ?>"><i class="fa fa-arrow-circle-left"></i> Back to Employee List</a></div>
  <div class="secondbtn"><a target="_blank" href="<?=base_url($username); ?>"><i class="fa fa-eye"></i> View ORG Chart</a></div>
</div>
<div class="note">Use drag and drop for Manage Chart</div><?php


$chart = orgchart_tree(0, $username);

if($username){
  $check = $this->db->query("SELECT id FROM user_master WHERE user_name = '".$username."'");
  $row = $check->row();
  if($row){
      $userid =  $row->id;

      $chartck = $this->db->query("SELECT * FROM user_master WHERE ceo = 1 AND company = '".$userid."'");
      $ct = $chartck->row();
      $image = ($ct->user_image)?'assets/userimage/'.$ct->user_image:'assets/images/user-profile.jpg';
      $chart = array('id' => $ct->id, 'title' => $ct->first_name.' '.$ct->last_name, 'name' => $ct->designation, 'image' => base_url($image), 'relationship' => array('children_num' => 3), 'children' => $chart);

      $query = $this->db->query("SELECT um.* 
                                   FROM user_master as um 
                                  WHERE um.status = 1 AND is_delete = 0 AND um.company = ".$userid);
      
      foreach ($query->result() as $res) {
        $image = ($res->user_image)?'assets/userimage/'.$res->user_image:'assets/images/user-profile.jpg';
        $id = $res->id;
        $designation = $res->designation;
        $userfullname = $res->first_name.' '.$res->last_name;
        $image = base_url($image);
        $skills = (trim($res->skill))?explode(',', trim($res->skill)):'';
        $abouts = (trim($res->about))?explode(',', trim($res->about)):''; ?>
        <div class="profile-sidebar" id="profile-sidebar-<?=$id;?>">
          <div class="member-profile-wrap">
              <div class="member-avtar">
                  <img src="<?=$image;?>" alt="<?=$userfullname;?>" />
              </div>
              <div class="member-detail">
                  <h3><?=$userfullname;?></h3>
                  <h5><?=$designation;?></h5>
              </div>
          </div>
          <div class="memeber-contact">
              <h4>Contact</h4>
              <!-- <div class="mem-cont-item"><img src="<?base_url('assets/chart/images/trophy.png');?>" alt="" />Started on March 10, 2017</div> --><?php
              if($res->city){ ?>
                <div class="mem-cont-item"><img src="<?=base_url('assets/chart/images/location.png');?>" alt="" /><?=$res->city;?></div><?php
              }
              if($res->email){ ?>
                <div class="mem-cont-item"><img src="<?=base_url('assets/chart/images/email.png');?>" alt="" /><?=$res->email;?></div><?php
              }
              if($res->phone){ ?>
                <div class="mem-cont-item"><img src="<?=base_url('assets/chart/images/phone.png');?>" alt="" /><?=$res->phone;?></div><?php
              } ?>
          </div><?php
          
          if($skills || $abouts){ ?>
            <div class="memeber-about">
              <h4>About</h4><?php
              if($skills){ ?>
                <div class="mem-abt-item">
                  <h5>Skills</h5>
                  <div class="mem-tag"><?php
                    foreach ($skills as $value) {
                      echo '<span>'.$value.'</span>';
                    } ?>
                  </div>
                </div><?php
              }
              if($abouts){ ?>
                <div class="mem-abt-item">
                  <h5>Interests</h5>
                  <div class="mem-tag"><?php
                    foreach ($abouts as $value) {
                      echo '<span>'.$value.'</span>';
                    } ?>
                  </div>
                </div><?php
              } ?>
            </div><?php
          } ?>
        </div><?php 
      }
  }
}


$chart =  json_encode($chart);
//$chart = substr_replace($chart,'',0,1);
//$chart = substr_replace($chart,'',-1);
/*if(!isJson($chart)){
  $chart = '{'.$chart.'}';
}
echo $chart; */ ?>

<div id="chart-container"></div>
<div class="chartbuttons chartbuttonsbottom">
  <div class="addbtn adduser"><a href="<?=base_url('employee'); ?>"><i class="fa fa-arrow-circle-left"></i> Back to Employee List</a></div>
  <div class="secondbtn"><a target="_blank" href="<?=base_url($username); ?>"><i class="fa fa-eye"></i> View ORG Chart</a></div>
</div>

<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/chart/js/jquery.orgchart.js"></script>
<script type="text/javascript">

  $(function() {

    var datascource = <?=$chart;?>;

    var oc = $('#chart-container').orgchart({
      'data' : datascource,
      'depth': 2,
      'nodeTitle': 'name',
      'nodeContent': 'title',
      'nodeID': 'id',
      'draggable': true,
      'createNode': function($node, data) {
        var nodePrompt = $('<i>', {
          click: function() {
            $(this).siblings('.second-menu').toggle();
          }
        });
        var secondMenu = '<div class="second-menu"><img class="avatar" src="' + data.image + '"></div>';
        $node.append(nodePrompt).append(secondMenu);
      }
    });

    oc.$chart.on('nodedrop.orgchart', function(event, extraParams) {
      $.ajax({
        type: "POST",
        url: "<?=base_url();?>/employee/save_orgchart", 
        data: {userid: extraParams.draggedNode[0].id, parentid: extraParams.dropZone[0].id },
        dataType: "text",  
        cache:false,
        success: function(data){
          
        }
      });
    });

  });
  </script>

  <!-- sidepanel script start-->
  <script>
    $(function(){
      $('.node').first().attr('draggable', 'false');
      $(".node").click(function(e) {
        $(".profile-sidebar").removeClass('show-sidebar');
        $("body").toggleClass("overflowhidden");
        var id = $(this).attr('id');
        if($("#profile-sidebar-"+id).hasClass('show-sidebar')){
          $("#profile-sidebar-"+id).removeClass("show-sidebar");
        }else{
          $("#profile-sidebar-"+id).addClass("show-sidebar");
          $("body").toggleClass("overflowhidden");
        }
        
        //console.log($(this).attr('id'));
      });
      $('body').click(function(evt){    
        if($(evt.target).closest('.profile-sidebar,.node').length)
        return;
        $("body").removeClass("overflowhidden");
        $(".profile-sidebar").removeClass("show-sidebar");
      });
  });
  </script>
   </body>
</html>