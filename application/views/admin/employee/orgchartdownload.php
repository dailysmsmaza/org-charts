<?php
error_reporting(E_ALL);
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$page_title;?></title>
    <link rel="stylesheet" href="<?=base_url();?>assets/chart/css/jquery.orgchart.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/chart/css/style.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/chart/css/sidebar.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/responsive.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <style type="text/css">h1 {color: #005ddb; font-size: 35px; } .center { position: absolute; height: 50px; top: 45%; left: 45%;  margin-left: -50px; /* margin is -0.5 * dimension */ margin-top: -25px; } .rightEdge, .leftEdge { display: none; }​ </style>
</head>
<body>
 
<?php
/*$userid =  $this->session->userdata('id');

$query1 = $this->db->query("SELECT um.id, um.first_name, um.last_name FROM user_master as um 
                                    JOIN employee_short as es ON um.id = es.item_id 
                                   WHERE um.status = 1 AND um.company = ".$userid." AND es.parent_id = 0 
                                ORDER BY es.id ASC");
$orgchartdata = array();
foreach ($query1 as $data) {
    
}
*/
$chart = orgchart_tree(0);

   if ($this->session->flashdata("success")) { ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success"); ?>
            </div>
        <?php } ?>  
        <?php if ($this->session->flashdata("fail")) { ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail"); ?>
            </div> <?php
         } 
$pdfhtml = '';
$username = $this->uri->segment(1);
if($username){ 
  $unm = $username;
  //echo $unm;
  ?>
  <!-- <a target="_blank" href="<?=base_url($username.'?pdf=1');?>">Download PDF</a> --><?php
  $check = $this->db->query("SELECT id,user_name FROM user_master WHERE user_name = '".$username."'");
  $row = $check->row();
  if($row){
      $userid =  $row->id;
      $sharepdfusrname =  $row->user_name;
      // echo $userid;
      // echo $username;  
     //  exit();
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
        $username = $res->first_name.' '.$res->last_name;
        $image = base_url($image);
        $skills = (trim($res->skill))?explode(',', trim($res->skill)):'';
        $abouts = (trim($res->about))?explode(',', trim($res->about)):'';
        $start_date = (trim($res->start_date))?date('d M, Y', strtotime($res->start_date)):'';
        $departmentname = '';
        if($res->department_id){
          $dquery = $this->db->query("SELECT * FROM department_master WHERE id = ".$res->department_id);
          $drow = $dquery->row();
          $departmentname = ($drow)?$drow->name:'';
        } ?>
        <div class="profile-sidebar" id="profile-sidebar-<?=$id;?>">
          <div class="member-profile-wrap">
              <div class="member-avtar">
                  <img src="<?=$image;?>" alt="<?=$username;?>" />
              </div>
              <div class="member-detail">
                  <h3><?=$username;?></h3>
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

          if($departmentname){ ?>
            <div class="memeber-about">
              <h4>Team</h4>
              <div class="mem-cont-item" style="padding-left: 15px;"><i class="fa fa-building-o" style="padding-right: 15px;"></i> <?=$departmentname;?></div>
            </div><?php
          }
          
          if($skills || $abouts || $start_date){ ?>
            <div class="memeber-about">
              <h4>About</h4><?php
              if($start_date){ ?>
                <div class="mem-abt-item" style="padding-left: 15px;">
                  <h5>Start Date</h5> 
                  <div class="mem-tag"><span><?=$start_date; ?></span></div>
                </div><?php
              }

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
$unm = json_encode($unm);
//print_r($chart);
//exit();
//$chart = substr_replace($chart,'',0,1);
//$chart = substr_replace($chart,'',-1);
/*if(!isJson($chart)){
  $chart = '{'.$chart.'}';
}

echo $chart; */ ?>

<script type="text/javascript" src="<?=base_url();?>assets/chart/js/orgchart.js"></script>

<div class="gc-orgchartdownload">
<div id="chart-container"> 
</div>
</div>
  <script type="text/javascript">
  function validForm()
  {
    var isvalidForm=true;
    $("#error_sharepdf_email").hide();
    $("#error_sharepdf_message").hide();
    var sharepdf_email=$("#sharepdf_email").val();
    var sharepdf_message=$("#sharepdf_message").val();
    //alert(message);
    if (sharepdf_email=='')
    {
      $("#error_sharepdf_email").show();
      $("#error_sharepdf_email").html('Please Enter Email');
      isvalidForm=false;
    }
    if(sharepdf_message=='')
    {
      $("#error_sharepdf_message").show();
      $("#error_sharepdf_message").html('Please Enter Message');
      isvalidForm=false;
    }
    if(sharepdf_email!=''){
       if (isEmail(sharepdf_email)==false) 
        {
          $("#error_sharepdf_email").show();
          $("#error_sharepdf_email").html('Please Enter Valid User Email');
          isvalidForm=false;
        } 

    }

    if(isvalidForm==true){
        return true;
    }else{
      return false;
    }
}

  function isEmail(sharepdf_email)
  {
    var validdatanm=function(sharepdf_email)
    {
      return  /^\S+@\S+\.\S+$/.test(sharepdf_email);
    }
    return validdatanm(sharepdf_email);
  }


</script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/es6-promise/4.1.1/es6-promise.auto.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/chart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/chart/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/chart/js/jquery.orgchart.js"></script>


<script type="text/javascript">

  $(function() {

    var datascource = <?=$chart;?>;
   // console.log(datascource);
    var username = <?=$unm;?>;
    //console.log(username);
    $('#chart-container').orgchart({
      'data' : datascource,
      'depth': 2,
      'nodeTitle': 'name',
      'nodeContent': 'title',
      'nodeID': 'id',
      'createNode': function($node, data) {
        //alert(data);
        var nodePrompt = $('<i>', {
          click: function() {
            $(this).siblings('.second-menu').toggle();
          }
        });

        var secondMenu = '<div class="second-menu"><img class="avatar" src="' + data.image + '"></div>';
        $node.append(nodePrompt).append(secondMenu);
      },
      'exportButton': true,
      'exportFileextension': 'pdf',
      'exportFilename': username
      });
      window.onload = function() {
          //alert("true");
       $(".oc-export-btn" ).click();  

      setTimeout(function () { window.close();}, 3000);

      //window.close();
    
     }
 });
</script>
<script>
    $(function(){
      $(document).on('click','.gcspnewrightbtn',function(){
          $('.gc-rightpanel').toggleClass('showrightpanel');
      });



      $(document).on('click','.orgchart',function(){
          $('.gc-rightpanel').removeClass('showrightpanel');
      });

      $(".node").click(function(e) {
        $(".profile-sidebar").removeClass('show-sidebar');
        $("body").toggleClass("overflowhidden");
        var id = $(this).attr('id');
        $("#profile-sidebar-"+id).toggleClass("show-sidebar");
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