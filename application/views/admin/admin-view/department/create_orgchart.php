  <?php
$role = $this->session->userdata('role');
$access_level=$this->session->userdata('access_level');
if($role==2 && $access_level==2){
       $companyid = $this->session->userdata('id');
}elseif ($role==3 && $access_level==2) {
        $companyid = $this->session->userdata('company');
}elseif($role==3 && $access_level==1) {
          $companyid = $this->session->userdata('company');
        }else{
    $companyid = $this->session->userdata("id");  
} 

$chartck = $this->db->query("SELECT * FROM department_master WHERE id = ".$department_id);
$ct = $chartck->row();

$departmentslug = ($ct)?$ct->slug:'';
$usersq = $this->db->query("SELECT id,user_name FROM user_master WHERE department_id = ".$department_id." AND company = '".$companyid."'");
if($usersq->num_rows()){
  foreach ($usersq->result() as $user) {
    $query = $this->db->query("SELECT * FROM department_employee_short WHERE item_id = ".$user->id);
    $sort = $query->row();
    if($sort){}else{
      $data = array('company_id' => $companyid, 'department_id' => $department_id, 'item_id' => $user->id, 'parent_id' => 0, 'depth' => 1);
       $this->db->insert('department_employee_short', $data);
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
  <div class="addbtn adduser"><a href="<?=base_url('department'); ?>"><i class="fa fa-arrow-circle-left"></i> Back to Department List</a></div>
  <div class="secondbtn"><a target="_blank" href="<?=base_url($username.'/team/'.$departmentslug); ?>"><i class="fa fa-eye"></i> View ORG Chart</a></div>
</div>
<div class="note">Use drag and drop for Manage Chart</div><?php

//echo $username." --- ".$department_id;
$chart = orgchart_tree(0, $username, $department_id);
$deparmentname = get_deparment_members($department_id);
if($username){
  $check = $this->db->query("SELECT id FROM user_master WHERE user_name = '".$username."'");
  $row = $check->row();
  if($row){
    $userid =  $row->id;

    $chartck = $this->db->query("SELECT * FROM department_master WHERE id = ".$department_id);
    $ct = $chartck->row();
    $image = 'assets/images/members.png';
    $chart = array('id' => 0, 'title' => $ct->name, 'name' => '', 'image' => base_url($image), 'children' => $chart);
  }
}


$chart =  json_encode($chart); ?>

<div id="chart-container" class="departmentchart"></div>
<div class="chartbuttons chartbuttonsbottom">
  <div class="addbtn adduser"><a href="<?=base_url('department'); ?>"><i class="fa fa-arrow-circle-left"></i> Back to Department List</a></div>
  <div class="secondbtn"><a target="_blank" href="<?=base_url($username.'/team/'.$departmentslug); ?>"><i class="fa fa-eye"></i> View ORG Chart</a></div>
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
      console.log(extraParams);
      $.ajax({
        type: "POST",
        url: "<?=base_url();?>department/dsaveorgchart", 
        data: {userid: extraParams.draggedNode[0].id, parentid: extraParams.dropZone[0].id, department_id: <?=$department_id;?> },
        dataType: "text",
        success: function(data){
          
        }
      });
    });

    $('.node').first().addClass('departmentnode');

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