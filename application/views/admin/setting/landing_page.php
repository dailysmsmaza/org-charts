<div class="maincontentarea smootheffect comleftnone clsmiddlesec">
  <div class="clshiddenconsec">
   <div class="maincontainer">
    <div class="pageconent">
        <div class="pageconentbx">
              <div class="pageheding">
                  <h2><?php echo $main_heading; ?></h2>              
              </div>
            <div class="whitebox">
            	<h1> <?php echo $heading_title ?></h1>
                <div class="formwraper">
                    <form method="POST" action="<?php echo base_url('setting/update_headersection'); ?>" enctype="multipart/form-data" name="landingpagesetting_form">                        
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Banner</label>
                                <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                    <input type="file" name="home_banner" class="form-control">
                                    <?php 
                                        if(get_themeoption("home_banner") !=""){
                                    ?>
                                    <div class="fileprev">
                                        <img src="<?php echo base_url('assets/setting/').get_themeoption('home_banner'); ?>" style="height:50px;">
                                    </div>                                    
                                <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Title</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <textarea name="home_title"><?php echo get_themeoption('home_title') ?></textarea>                        
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Description</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"> <textarea name="home_description" ><?php echo get_themeoption('home_description') ?></textarea></div>
                            </div>                           
                            <div class="form-group row">
                                <input type="submit" value="Submit">
                            </div>                     
                        </form>
                        <h1> <?php echo $heading_title2 ?></h1>
                        <form method="POST" action="<?php echo base_url('setting/update_middelsection'); ?>" enctype="multipart/form-data" name="landingpagemiddlesetting_form">                                            
                                <div class="form-group row">
                                    <label class="col-md-3 col-lg-3 col-xl-2">Banner</label>
                                    <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                        <input type="file" name="home_middelbanner" class="form-control">
                                        <?php 
                                           if(get_themeoption("home_middelbanner") !=""){
                                        ?>
                                         <div class="fileprev">
                                            <img src="<?php echo base_url('assets/setting/').get_themeoption('home_middelbanner'); ?>" style="height:50px;">
                                        </div>   
                                    <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-lg-3 col-xl-2">Title</label>
                                    <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" class="form-control" name="home_middeltitle" value="<?php echo get_themeoption('home_middeltitle') ?>"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-lg-3 col-xl-2">Description</label>
                                    <div class="col-md-9 col-lg-9 col-xl-10"><textarea name="home_middeldescription"><?php echo get_themeoption("home_middeldescription") ?></textarea></div>
                                </div>
                               
                                <div class="form-group row">
                                    <input type="submit" value="Submit">
                                </div>    
                            </table>
                        </form>
                        <h1> <?php echo $heading_title3 ?></h1>
                        <form method="POST" action="<?php echo base_url('setting/update_thirdsection'); ?>" enctype="multipart/form-data" name="landingpagethirdsetting_form">                    
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Banner</label>
                                <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                    <input type="file" name="testimonial_banner" class="form-control">
                                    <?php 
                                       if(get_themeoption("testimonial_banner") !=""){
                                    ?>
                                    <img src="<?php echo base_url('assets/setting/').get_themeoption('testimonial_banner'); ?>" style="height:50px;">
                                <?php } ?>
                                </div>
                            </div>                                      
                            <div class="form-group row">
                                <input type="submit" value="Submit">
                            </div>                    
                        </form> 
                        <h1> <?php echo $heading_title4 ?></h1>
                        <form method="POST" action="<?php echo base_url('setting/update_fourthsection'); ?>" enctype="multipart/form-data" name="landingpagefourthsetting_form">                    
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Banner</label>
                                <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                    <input type="file" name="home_fourthsectionbanner" class="form-control">
                                    <?php 
                                       if(get_themeoption("home_fourthsectionbanner") !=""){
                                    ?>
                                    <img src="<?php echo base_url('assets/setting/').get_themeoption('home_fourthsectionbanner'); ?>" style="height:50px;">
                                <?php } ?>
                                </div>
                            </div>                                      
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Title</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" class="form-control" name="home_fourthsectiontitle" value="<?php echo get_themeoption('home_fourthsectiontitle') ?>">
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Description</label>
                                <div class="col-md-9 col-lg-9 col-xl-10"><textarea name="home_fourthsectiondescription"><?php echo get_themeoption("home_fourthsectiondescription") ?></textarea></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Read More Button Title</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" class="form-control" name="home_fourthsectionreadmorebuttontitle" value="<?php echo get_themeoption('home_fourthsectionreadmorebuttontitle') ?>">
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-lg-3 col-xl-2">Read More Button Link</label>
                                <div class="col-md-9 col-lg-9 col-xl-10">
                                    <input type="text" class="form-control" name="home_fourthsectionreadmorebuttonlink" value="<?php echo get_themeoption('home_fourthsectionreadmorebuttonlink') ?>">
                                </div>                                
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
 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    
    CKEDITOR.replace( 'home_title', {
    language: 'en',
    uiColor: '#FFFFFF',    
    toolbarCanCollapse:true
});

    CKEDITOR.replace( 'home_description', {
        language: 'en',
        uiColor: '#FFFFFF',        
        toolbarCanCollapse:true
    });
    CKEDITOR.replace( 'home_middeldescription', {
        language: 'en',
        uiColor: '#FFFFFF',        
        toolbarCanCollapse:true
    });
    CKEDITOR.replace( 'home_fourthsectiondescription', {
        language: 'en',
        uiColor: '#FFFFFF',        
        toolbarCanCollapse:true
    });
    
CKEDITOR.config.allowedContent = true;
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

     $(function() {
         $("form[name='landingpagethirdsetting_form']").validate({
                //set Validation rules    
                rules: {
                 testimonial_banner:{ required:true}                 
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
         $("form[name='landingpagefourthsetting_form']").validate({
                //set Validation rules    
                rules: {
                 //home_fourthsectionbanner:{ required:true},
                 home_fourthsectiontitle:{ required:true},                    
                 home_fourthsectiondescription:{ required:true},
                 home_fourthsectionreadmorebuttontitle:{ required:true},
                 home_fourthsectionreadmorebuttonlink:{ required:true},
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