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
                    <form method="post" action=""  name="employee_form" enctype="multipart/form-data">        <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Company</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <?php 
                                        $companyid = $this->uri->segment(3);
                                        $company   =  get_userinfo($companyid,"first_name","last_name");
                                     ?>
                                     <h2><?php echo $company["first_name"]." ".$company["last_name"] ?></h2>
                                     <input type="hidden" name="company" id="companyid" value="<?php echo $companyid ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">User Image</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><input type="file" name="user_image" class="form-control"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">First Name</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="first_name" class="form-control" value="<?=set_value('first_name');?>"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Last Name</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="last_name" class="form-control" value="<?=set_value('last_name');?>"></div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Email</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="email" class="form-control" value="<?=set_value('email');?>"></div>
                            </div>               
                            
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Phone</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" id="phone" name="phone" class="form-control" value="<?=set_value('phone');?>"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Designation</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" name="designation" class="form-control" value="<?=set_value('designation');?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">About</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <textarea name="about" cols="35" rows="5" class="form-control"><?=set_value('about');?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Skill</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" name="skill" class="form-control" value="<?=set_value('skill');?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Address</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <textarea name="city" class="form-control"><?=set_value('first_name');?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Team</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <select class="select2 form-control" name="department_id" id="department_id">
                                        <option value="0">Select Team</option><?php
                                        $query = $this->db->query("SELECT * FROM department_master WHERE status = 1 AND company_id = ".$companyid." ORDER BY name ASC");
                                        if($query->num_rows()){
                                            foreach ($query->result() as $user) { ?>
                                                <option value="<?=$user->id;?>"><?=$user->name;?></option><?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Line manager</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <select class="select2 form-control" name="parent_employee" id="parent_employee">
                                        <option value="0">Select Line manager</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM user_master WHERE status = 1 AND is_delete = 0 AND company = ".$companyid." ORDER BY ceo DESC,first_name ASC, last_name ASC");
                                          if($query->num_rows()){
                                            foreach ($query->result() as $user) { 
                                                if($user->ceo==1){
                                                     ?>
                                                <option value="0">CEO: <?=$user->first_name.' '.$user->last_name;?></option><?php
                                                }else{
                                             ?>
                                                <option value="<?=$user->id;?>"><?=$user->first_name.' '.$user->last_name;?></option><?php
                                                 }
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Start Date</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" name="start_date" class="form-control datepicker" value="<?=set_value('start_date');?>">
                                </div>
                            </div>
                                <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Access Level</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                   <select class="select2 form-control" name="access_level" id="access_level">      <option value="0">Basic</option>
                                         <option value="1">Team lead</option>
                                         <option value="2">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <input type="submit" value="Add Employee">
                            </div>                                  
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>
        <script src="<?php echo base_url('assets/js/') ?>jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery_validation.js') ?>"></script>  
        <script src="<?php echo base_url() ?>assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>      
        <!--Jquery Validation --->
        <script type="text/javascript">
            $(function () {
                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                });
                $("form[name='employee_form']").validate({                    
                    rules: {
                        
                        user_image: {required: true},
                        first_name: {required: true},
                        last_name: {required: true},     
                        email:{required:true,email:true},                                                            
                       // phone: {required: true, number: true},
                        designation: {required: true},                        
                       // skill: {required: true},
                        //city: {required: true}
                    },                    
                    messages: {                        
                    },
                    //Add Color To Message
                    highlight: function (element) {
                        $(element).parent().addClass('error_msg')
                    },                    
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
                var companyid = $('#companyid').val();
               // alert(companyid);
                if(department_id){
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url();?>/company/get_cmpemployee_by_department", 
                        data: {id: department_id,companyid: companyid},
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
            }, 10000);
            setTimeout(function () {
                $(".alert-success").hide()
            }, 10000);
        </script>
    </body>
</html>