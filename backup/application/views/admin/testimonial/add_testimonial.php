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
                    <form method="post" action="<?php echo base_url('testimonial/add_testimonial') ?>"  name="testimonial_form" enctype="multipart/form-data">                                 
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Company</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <select name="company" onchange="get_company_employee(this.value)" class="form-control">
                                        <option selected="" disabled="">Select Company</option>
                                        <?php
                                        foreach ($company as $company_list) {
                                            ?>                            
                                            <option value="<?php echo $company_list["id"]; ?>"><?php echo $company_list["first_name"] . " " . $company_list["last_name"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Employee</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <select name="employee" id="resultarea" class="form-control">
                                        <option selected='' disabled=''>Select Employee</option>
                                        
                                    </select>  
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Message</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <textarea name="message" cols="35" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type="submit" value="Add Testimonial">
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
<!--Jquery Validation --->
<script type="text/javascript">
    $(function () {
        $("form[name='testimonial_form']").validate({
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
    function get_company_employee(id) {
        var url = "<?php echo base_url('testimonial/get_company_employee'); ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: {company: id},
            cache: false,
            success: function (data) {                            
                var employee = JSON.parse(data);                           
                var html = "<option selected='' disabled=''>Select Employee</option>";
                if(employee.length > 0){
                    for (i = 0; i < employee.length; i++) { 
                        html +="<option value="+employee[i]['id']+">"+employee[i]['first_name']+" "+employee[i]['last_name']+"</option>"
                    }
                    $("#resultarea").empty();
                    $("#resultarea").html(html);    
                }else{
                    $("#resultarea").html("<option>Data Not Found</option>");    
                }
                
            }
        });
    }
</script>