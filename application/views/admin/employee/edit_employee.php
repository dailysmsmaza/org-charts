<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
<div class="clshiddenconsec">
<div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title; ?></h2>              
              </div>
                <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo validation_errors(); ?>
                        </div>
                    <?php } ?>

                    <?php
                    if ($this->session->flashdata("fail")) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail") ?>
                        </div>
                <?php } ?>
            <div class="whitebox">
                <div class=""></div>
                <div class="formwraper">
                <form method="post" action=""  name="user_form" enctype="multipart/form-data">
                    <div class="form-group row">                        
                            <label class="col-md-3 col-lg-3 col-xl-2">Company</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                    <?php 
                                        $role =  $this->session->userdata('role');
                                        $access_level=$this->session->userdata('access_level');
                                        if($role==2 && $access_level==2){
                                          $companyid = $this->session->userdata("id");
                                        }elseif ($role==3 && $access_level==2) {
                                          $companyid = $this->session->userdata("company");
                                        }else{
                                          $companyid = $this->session->userdata("id");
                                        } 
                                       // $companyid = $this->session->userdata("id");
                                        $company   =  get_userinfo($companyid,"first_name","last_name");
                                       ?>
                                     <h2><?php echo $company["first_name"]." ".$company["last_name"] ?></h2>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">User Image</label>
                            <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                <input type="file" name="user_image" class="form-control">
                                <input type="hidden" name="old_user_image" value="<?php echo $edit_employee['user_image'] ?>" class="form-control">                               
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">First Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="first_name" value="<?php echo (set_value('first_name'))?set_value('first_name'):$edit_employee['first_name'] ?>" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Last Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="last_name" value="<?php echo (set_value('last_name'))?set_value('last_name'):$edit_employee['last_name'] ?>" class="form-control"></div>
                        </div>                        
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Email</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="email" value="<?php echo (set_value('email'))?set_value('email'):$edit_employee['email'] ?>" class="form-control"></div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Password</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="password" name="password" value="" class="form-control"></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Phone</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="phone" id="phone"  value="<?php echo (set_value('phone'))?set_value('phone'):$edit_employee['phone'] ?>" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Designation</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="designation" value="<?php echo (set_value('designation'))?set_value('designation'):$edit_employee['designation']; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">About</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="about" cols="35" rows="5" class="form-control"><?php echo (set_value('about'))?set_value('about'):$edit_employee['about'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Skill</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="skill" value="<?php echo (set_value('skill'))?set_value('skill'):$edit_employee['skill'] ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Address</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="city" class="form-control"><?php echo (set_value('city'))?set_value('city'):$edit_employee['city'] ?></textarea>                                
                            </div>
                        </div>
                         <?php if($edit_employee['id']!=''){
                                        $usrceo = get_userinfo($edit_employee['id'], 'ceo', 'id');
                                   } 
                                   if($usrceo['ceo']!=1){ ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Team</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <select class="select2 form-control" name="department_id" id="department_id">
                                   
                                   <option value="0">Select Team</option>

                                    <?php
                               

                                    $query = $this->db->query("SELECT * FROM department_master WHERE status = 1 AND parent_id=0 AND company_id = ".$companyid." ORDER BY parent_id ASC");
                                    if($query->num_rows()){
                                        foreach ($query->result() as $user) { ?>
                                            <option <?=($edit_employee['department_id'] == $user->id)?'selected':'';?> value="<?=$user->id;?>"><?=$user->name;?></option><?php
                                                $subquery = $this->db->query("SELECT * FROM department_master WHERE status = 1 AND parent_id='".$user->id."' AND company_id = ".$companyid." ORDER BY parent_id ASC");
                                                 if($subquery->num_rows()){
                                                    foreach ($subquery->result() as $subteam) { ?>
                                                        <option <?=($edit_employee['department_id'] == $subteam->id)?'selected':'';?> value="<?=$subteam->id;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$subteam->name;?></option><?php
                                                       }
                                                }
                                        }
                                    } 
                               ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Line manager</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <select name="parent_employee" class="select2 form-control" id="parent_employee">
                                   <option value="0">Select Line manager</option><?php
                                    $cquery = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$edit_employee['id']);
                                    //print_r($cquery);echo "jjjjjjjj";
                                    $crow = $cquery->row();
                                    $current = ($crow)?$crow->parent_id:0;

                                    $departmentcond = ($edit_employee['department_id'])?' AND department_id = '.$edit_employee['department_id']:'';

                                     $query = $this->db->query("SELECT * FROM user_master WHERE status = 1 AND is_delete = 0 AND company = ".$companyid." AND id != ".$edit_employee['id'].$departmentcond." or (ceo=1 and company=".$companyid.") ORDER BY ceo DESC,first_name ASC, last_name ASC");
                                     
                                     if($query->num_rows()){
                                        foreach ($query->result() as $user) { 
                                            if($user->ceo==1){
                                                     ?>
                                                <option <?=($current == $user->id)?'selected':'';?> value="0">CEO: <?=$user->first_name.' '.$user->last_name;?></option><?php
                                                }else{
                                             ?>
                                                <option <?=($current == $user->id)?'selected':'';?> value="<?=$user->id;?>"><?=$user->first_name.' '.$user->last_name;?></option><?php
                                                 }
                                                 
                                        }
                                    } 
                                ?>
                                </select>
                            </div>
                        </div>

                        <?php
                    }
                        $start_date = ($edit_employee['start_date'])?date('d-m-Y', strtotime($edit_employee['start_date'])):''; ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Start Date</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="start_date" class="form-control datepicker" value="<?php echo (set_value('start_date'))?set_value('start_date'):$start_date; ?>">
                            </div>
                        </div>
                         <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Access Level</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                   <select class="select2 form-control" name="access_level" id="access_level">   <option value="0" <?php if($edit_employee['access_level']=='0'){ echo set_select('access_level', "0",TRUE); }?>>Basic</option>
                                        <option value="1" <?php if($edit_employee['access_level']=='1'){ echo set_select('access_level', "1", TRUE); } ?>>Team lead</option>
                                        <option value="2" <?php if($edit_employee['access_level']=='2'){ echo set_select('access_level', "2", TRUE); } ?>>Administrator</option>
                                    </select>
                                </div>
                            </div>
                        <div class="form-group row">
                           <input type="submit" value="Update Employee">
                        </div>			
                    
                </form>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>

<script src="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery_validation.js') ?>"></script>
        
<!--Jquery Validation --->
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });
        $("form[name='user_form']").validate({
            //set Validation rules    
            rules: {
               
                first_name: {required: true},
                last_name: {required: true},                 
                email: {required: true, email: true},
                designation: {required: true},
                //skill: {required: true},
                //city: {required: true}
            },
            // Specify validation error messages
            messages: {
                confirmpassword: {equalTo: "Password and Confirm Password Does Not matche"},
            },
            //Add Color To Message
            highlight: function (element) {
                $(element).parent().addClass('error_msg')
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });
        
        $('#phone').keypress(function (e) {
            var regex = new RegExp("^[0-9\-]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            $("#phoneerror_msg").text("Please Enter Only Digits & Hyphen.").css({"color":"#ff0000","font-size":"13px"})
            setTimeout( function(){$('#phoneerror_msg').hide();} , 2000);;
            e.preventDefault();
            return false;       
        });

        $('#department_id').change(function(){
            var department_id = $(this).val();
            if(department_id){
                $.ajax({
                    type: "POST",
                    url: "<?=base_url();?>/employee/get_employee_by_department", 
                    data: {id: department_id },
                    dataType: "text",  
                    cache:false,
                    success: function(data){
                      $('#parent_employee').html(data);
                    }
                });
            }
        });

    });
    setTimeout(function () {
        $(".alert-danger").hide()
    }, 3000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 3000);
</script>

<script src="<?php echo base_url('assets/select2/select2.full.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>