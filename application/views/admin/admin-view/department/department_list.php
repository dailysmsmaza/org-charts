<?php
$role =  $this->session->userdata('role');
$access_level =  $this->session->userdata('access_level');
$companyid = $this->uri->segment(3);
$addurl = ($role == 1)?'company/department/'.$companyid.'/add':'department/add_department'; ?>
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
    <div class="clshiddenconsec">
        <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title ?></h2>
                 <?php if($access_level!=1) { ?> <div class="addbtn adduser"><a href="<?php echo base_url($addurl) ?>"><span class="plusicon"><img src="<?php echo base_url('assets/') ?>images/plusicon.png" alt="" /></span>Add Team</a></div><?php } ?>
              </div>
              <div id="response"> </div>
              <?php if ($this->session->flashdata("success")) { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success"); ?>
                    </div>
                <?php } ?>  
              <div class="whitebox">
              	<div class=""></div>
                <table class="mobiletable userslist-table">
                    <thead>                        
                        <tr>            
                            <th>Name</th>
                            <th>Short Description</th>            
                            <th>Status</th><?php
                            if(($role == 2 && $access_level==2) || ($role == 3 && $access_level==2) || ($role == 3 && $access_level==1)){ ?>
                                <th>ORG Chart</th><?php
                            } ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php

                        if($role==2 && $access_level==2){
                          $userid =  $this->session->userdata('id');
                        }elseif ($role==3 && $access_level==2) {
                          $userid = $this->session->userdata('company');
                        }elseif($role==3 && $access_level==1) {
                          $userid = $this->session->userdata('company');
                        }else{ 
                          $userid =  $this->session->userdata('id');
                        }
                        
                        $username = ''; $num = 0;
                        if($userid){
                            $username = get_userinfo($userid, 'user_name', 'id');
                            $username = ($username)?$username['user_name']:'';

                            $query =  $this->db->query('SELECT * FROM department_master WHERE company_id = '.$userid );
                            $num = $query->num_rows();
                        }
                        //print_r($department);
                        if (!empty($department)) {
                            foreach ($department as $testimonial_list) {
                                $members = get_deparment_members($testimonial_list['department_id']);
                                $edit = 'department/edit/' . $testimonial_list['department_id'];
                                $subteam='department/subteam/' . $testimonial_list['department_id'];
                                
                                if($role == 1){
                                    $userid =  $testimonial_list['company_id'];
                                    $username = get_userinfo($userid, 'user_name', 'id');
                                    $username = ($username)?$username['user_name']:'';

                                    $edit = 'company/department/'.$userid.'/edit/' . $testimonial_list['department_id'];
                                    $subteam='company/department/'.$userid.'/subteam/' . $testimonial_list['department_id'];

                                }

                                $desquery =  $this->db->query('SELECT * FROM department_employee_short WHERE department_id = '.$testimonial_list['department_id']);

                                $desnum = $desquery->num_rows(); ?>
                                <tr>
                                    <td><?php echo $testimonial_list["name"]; ?></td>
                                    <td><?php echo $testimonial_list["description"] ?></td>
                                    <td class="<?php echo ($testimonial_list["status"] == 1) ? 'activestatus' : 'deactivestatus' ?>"><?php echo ($testimonial_list["status"] == 1) ? "Active" : "Deactive" ?></td><?php
                                    if(($role == 2 && $access_level==2)|| ($role == 3 && $access_level==2) || ($role == 3 && $access_level==1)){ ?>
                                        <td class="action-td">
                                            <a href="<?=($members)?base_url('department/'.$testimonial_list['department_id'].'/create-orgchart'):'javascript: void(0)';?>" <?=($members)?'':'onclick="addemployee();"';?> class="text-info" title="Create ORG Chart"><i class="fa fa-pie-chart" aria-hidden="true"></i></a><?php
                                            if($members && $desnum){ ?>
                                                <a target="_blank" href="<?=base_url($username.'/team/'.$testimonial_list['slug']);?>" class="text-success" title="View ORG Chart"><i class="fa fa-eye" aria-hidden="true"></i></a><?php
                                            } ?>
                                            </td><?php
                                    } ?>
                                    <td class="action-td">

                                        <?php
                                        if($members && $role == 1 && $desnum){ ?>
                                            <a target="_blank" href="<?=base_url($username.'/team/'.$testimonial_list['slug']);?>" class="text-success" title="View ORG Chart"><i class="fa fa-pie-chart" aria-hidden="true"></i></a><?php
                                        } 
                                        $status = "";
                                        ($testimonial_list["status"] == 1) ? $status = 0 : $status = 1; ?>
                                        <?php if($access_level!=1) { ?>
                                        <a class="actionicon activeicon" href="<?php echo base_url('department/changestatus/' . $status . '/' . $testimonial_list['department_id']) ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        <a class="actionicon editicon"  href="<?php echo base_url($edit) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a class="actionicon deleteicon" onclick="return confirm('Are You Sure Want To Delete This Record?')" href="<?php echo base_url('department/delete/' . $testimonial_list['department_id']) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <!-- sub team link -->
                                        <?php } ?>
                                        <a class="actionicon editicon"  href="<?php echo base_url($subteam); ?>"><i class="fa fa-users" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="5">Not Data Found</td></tr>
                        <?php } ?>
                        <tr><td colspan="5">Total Record (s) : <?php echo $total_department ?></td></tr>
                    </tbody>
                </table>
        <div class="pagination" style="margin-left:550px;">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo base_url('assets/') ?>js/jquery.basictable.min.js"></script>
<script>
  $(document).ready(function() {
      $('.mobiletable').basictable({
        breakpoint: 991
      });
  });

  function addemployee(){
    $('#response').html('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> Please add employee in this Team. </div>');
  }
</script>
<script type="text/javascript">
     setTimeout(function () {
        $(".alert-danger").hide()
    }, 3000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 3000);
</script>
