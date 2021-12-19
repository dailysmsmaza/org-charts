<?php $role =  $this->session->userdata('role');
$access_level=$this->session->userdata('access_level');
if($role==1){
    $companyid = $this->uri->segment(3);
}else{
     if($role==2 && $access_level==2 ){
        $companyid = $this->session->userdata("id");
    }elseif($role==3 && $access_level==2){
        $companyid = $this->session->userdata("company");
    }
}
$company   =  get_userinfo($companyid,"first_name","last_name");
if($role==1){
    $departmentid = $this->uri->segment(7);
}else{
    $departmentid = $this->uri->segment(5);
}
?>
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
                    <form method="post" action=""  name="department_form" enctype="multipart/form-data"><?php
                        if(isset($companyname)){ ?>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Company Name</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <h4><?=$companyname;?></h4>
                                </div>
                            </div><?php
                        } ?>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="name" id="name" required="required" class="form-control" value="<?=($edit_subteam)?$edit_subteam['name']:set_value('name');?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Short Description</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="description" cols="35" rows="5" class="form-control"><?php echo ($edit_subteam)?$edit_subteam["description"]:set_value('description'); ?></textarea>
                            </div>
                        </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Select Employee</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <select class="demo" id="employee_id" name="employee_id[]" multiple >
                                <?php
                                //$query = $this->db->query("SELECT * FROM `user_master` where status=1 and role=3");
                                   $query = $this->db->query("SELECT * FROM `user_master` where status=1 and role=3 and company=".$companyid);
                                    if($query->num_rows()){
                                        foreach ($query->result() as $user) {
                                          ?>
                                            <option <?php echo ($user->department_id==$departmentid?'selected="selected"':'');?> value="<?=$user->id;?>"><?=$user->first_name.' '.$user->last_name;?></option>
                                            <?php
                                        }
                                    }
                                     ?>
                                 </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="submit" value="<?=($edit_subteam)?'Update Sub Team':'Add Sub Team';?>">
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
                  $(function () {
                    $("form[name='department_form']").validate({
                        rules: {
                            company: {required: true},                            
                            message: {required: true}
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
                });
                setTimeout(function () {
                    $(".alert-danger").hide()
                }, 3000);
                setTimeout(function () {
                    $(".alert-success").hide()
                }, 3000);

                 /*
                 *  Get Company Employee
                 */
                function get_company_employee(id,employee_id) {                 
                    var url = "<?php echo base_url('department/get_company_employee'); ?>";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {company: id},
                        cache: false,
                        success: function (data) {                            
                            var employee = JSON.parse(data);                           
                            var html = "<option selected='' disabled=''>Select Employee</option>";                            
                            if(employee.length > 0){
                                $.each(employee,function(key,value){
                                    
                                    if(employee_id == value.id){
                                        html +="<option value="+value.id+" selected>"+value.first_name+" "+value.last_name+"</option>"
                                    }else{
                                        html +="<option value="+value.id+" >"+value.first_name+" "+value.last_name+"</option>"
                                    }                                                                        
                                
                                });                                
                                $("#resultarea").html(html);    
                            }else{
                                $("#resultarea").html("<option>Data Not Found</option>");    
                            }
                            
                        }
                    });
                }
/*
 * Get Company id and Check Employee
*/
 $(function () {
     var selectedCompany  = $("#company").children("option:selected").val();
     var selectedemployee = <?php echo $edit_department["user_id"] ?>;    
     get_company_employee(selectedCompany,selectedemployee);
});
</script>
<script src="<?php echo base_url('assets/js/tokenize2.js') ?>"></script>
<script type="text/javascript">
    $('.demo').tokenize2();
</script>