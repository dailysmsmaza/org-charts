<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $heading_title; ?></h2>              
              </div>
            <div class="whitebox">
                <div class="formwraper">
        	       <form method="POST" action="<?php echo base_url('setting/update_generalsetting'); ?>" enctype="multipart/form-data" name="setting_form">
            	        <div class="form-group row">        	            
            	           <label class="col-md-3 col-lg-3 col-xl-2">Favicon</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
        	                    <input type="file" name="favicon"> 
        	                    <?php 
        	                        if(get_themeoption('favicon')!=""){
        	                     ?>             
        	                    <img src="<?php echo base_url('assets/setting/').get_themeoption('favicon') ?>">
        	                   <?php } ?>
        	                </div>
            	       </div>   
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Logo</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
        	                    <input type="file" name="logo">
                                 <?php 
                                    if(get_themeoption('logo')!=""){
                                 ?>  
                                <div class="fileprev">
                                    <img src="<?php echo base_url('assets/setting/').get_themeoption('logo') ?>">
                                </div>
        	                   <?php } ?>
        	                </div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Site Name</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="sitename" value="<?php echo get_themeoption('sitename') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Address</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><textarea name="address" class="form-control"><?php echo get_themeoption('address') ?></textarea></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Phone</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" maxlength="10" name="phone" value="<?php echo get_themeoption('phone') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Email</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="email" value="<?php echo get_themeoption('email') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Copy Right</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="copyright" value="<?php echo get_themeoption('copyright') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Facebook</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="facebook" value="<?php echo get_themeoption('facebook') ?>"  class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Twitter</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="twitter" value="<?php  echo get_themeoption('twitter') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Instagram</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10 "><input type="text" name="instagram" value="<?php echo  get_themeoption('instagram')?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">Pintrest</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="pinterest" value="<?php echo  get_themeoption('pinterest')?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <label class="col-md-3 col-lg-3 col-xl-2">LinkdIn</label>
        	                <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="linkedin" value="<?php echo get_themeoption('linkedin') ?>" class="form-control"></div>
        	            </div>
        	            <div class="form-group row">
        	                <input type="submit" value="Submit">
        	            </div>
        	        </form>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>	    

<script  src="<?php echo base_url('assets/') ?>js/jquery_validation.js"></script>       
   <!-- Genral Setting Jquery Validation --->
<script type="text/javascript">
    $(function() {
         $("form[name='setting_form']").validate({
                //set Validation rules    
                rules: {
                	//favicon:{ required:true},
                    //logo:{ required:true },
                    sitename:{
                         required:true
                    },
                    address:{
                    	required:true
                    },
                    phone:{
                    	required:true,
                    	number:true
                    },
                    email:{
                    	required:true,
                    	email:true
                    },
                    copyright:{
                    	required:true
                    },
                    facebook:{
                    	required:true,
                    	url:true
                    },
                    twitter:{
                    	required:true,
                    	url:true
                    },
                    instagram:{
                    	required:true,
                    	url:true
                    },
                    pintrest:{
                    	required:true,
                    	url:true
                    },
                    linkdin:{
                    	required:true,
                    	url:true
                    }
                                                        
                },
                 // Specify validation error messages
                messages: {                    
                    
                },
                //Add Color To Message
                highlight: function (element) {
                    $(element).parent().addClass('error_msg')
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                  form.submit();
                }
        });
    });
</script>
<!-- Leandig Page  Setting Jquery Validation --->
<script type="text/javascript">
      
    $(function() {
         $("form[name='setting_form']").validate({
                //set Validation rules    
                rules: {
                    home_banner:{ required:true},
                    
                    sitename:{
                         required:true
                    },
                    description:{
                        required:true
                    }                                   
                },
                 // Specify validation error messages
                messages: {                    
                    
                },
                //Add Color To Message
                highlight: function (element) {
                    $(element).parent().addClass('error_msg')
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                  form.submit();
                }
        });
    });

     $(function() {
         $("form[name='landingpagemiddlesetting_form']").validate({
                //set Validation rules    
                rules: {
                   // home_banner:{ required:true},
                    
                    sitename:{
                         required:true
                    },
                    description:{
                        required:true
                    }                                   
                },
                 // Specify validation error messages
                messages: {                    
                    
                },
                //Add Color To Message
                highlight: function (element) {
                    $(element).parent().addClass('error_msg')
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                  form.submit();
                }
        });
    });
    setTimeout(function(){ $(".alert-danger").hide() }, 3000);
    setTimeout(function(){ $(".alert-success").hide() }, 3000);
 </script>