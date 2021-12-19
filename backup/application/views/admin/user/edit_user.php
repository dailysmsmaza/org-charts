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
                <?php 
                 /* Get Segment*/
                  $secnond_segment = $this->uri->segment(2);
                ?>
            <div class="whitebox">
                <div class="formwraper">
                    <form method="post" action="<?php echo base_url('user/edit/'.$edit_user['id']) ?>"  name="user_form" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">User Image</label>
                            <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                <input type="file" name="user_image" class="form-control">
                                <input type="hidden" name="old_user_image" value="<?php echo $edit_user['user_image'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">First Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="first_name" id="first_name" value="<?php echo (set_value('first_name'))?set_value('first_name'):$edit_user['first_name'] ?>" class="form-control"><label class="error" for="first_name"></label></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Last Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="last_name" id="last_name" value="<?php echo (set_value('last_name'))?set_value('last_name'):$edit_user['last_name'] ?>" class="form-control"><label class="error" for="last_name"></label></div>
                        </div>                   
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Email</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="email" id="email" value="<?php echo (set_value('email'))?set_value('email'):$edit_user['email'] ?>" class="form-control"><label class="error" for="email"></label></div>
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Password</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="password" value="<?=set_value('password');?>" name="password" id="password" class="form-control"><label class="error" for="password"></label></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Phone</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="phone" id="phone" value="<?php echo (set_value('phone'))?set_value('phone'):$edit_user['phone'] ?>" class="form-control"><label class="error" for="phone"></label></div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Designation</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="designation" value="<?php echo $edit_user['designation'] ?>" class="form-control">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">About</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="about" cols="35" rows="5" class="form-control"><?php echo (set_value('about'))?set_value('about'):$edit_user['about'] ?></textarea>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Skill</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <input type="text" name="skill" value="<?php echo $edit_user['skill'] ?>" class="form-control">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Address</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="city" id="city" class="form-control"><?php echo (set_value('city'))?set_value('city'):$edit_user['city'] ?></textarea><label class="error" for="city"></label>                                
                            </div>
                        </div>                
                        <div class="form-group row">
                            <input type="submit" id="update_user" value="Update User">
                        </div>                              
                </form>
            </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>
        
        <?php 
            if($secnond_segment == "edit"){
        ?>
        <script src="<?php echo base_url('assets/js/') ?>jquery-3.2.1.min.js"></script>                 
    <?php } ?>         
<!--Jquery Validation --->
<script type="text/javascript">
    $(function () {
        $('#update_user').click(function(event){
            //event.preventDefault(); 
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var phone = $('#phone').val();
            var city = $('#city').val();
            var error = 0;

            if(first_name){ $('#first_name').next('label').text(''); $('#first_name').next().hide(); }
            else{ $('#first_name').next('label').text('This field is required.'); $('#first_name').next().show(); error = 1; }

            if(last_name){ $('#last_name').next('label').text(''); $('#last_name').next().hide(); }
            else{ $('#last_name').next('label').text('This field is required.'); $('#last_name').next().show(); error = 1; }

            if(email){ 
                $('#email').next('label').text(''); $('#email').next().hide(); 
                if(!isEmail(email)){
                    $('#email').next('label').text('Please enter valid email address.'); 
                    $('#email').next().show(); error = 1;
                }
            }
            else{ $('#email').next('label').text('This field is required.'); $('#email').next().show(); error = 1; }

            if(phone){ $('#phone').next('label').text(''); $('#phone').next().hide(); }
            else{ $('#phone').next('label').text('This field is required.'); $('#phone').next().show(); error = 1; }

            if(city){ $('#city').next('label').text(''); $('#city').next().hide(); }
            else{ $('#city').next('label').text('This field is required.'); $('#city').next().show(); error = 1; }

            if(error){
                return false;
            }else{
                return true;
            }
        });

        /*$("form[name='user_form']").validate({
            //set Validation rules    
            rules: {                      
                company: {required: true},                        
                first_name: {required: true},
                last_name: {required: true},
                user_name: {required: true},
                email: {required: true, email: true},
                //password: {required: true},                   
                phone: {required: true},
               // designation: {required: true},
                //about: {required: true},
                //skill: {required: true},
                city: {required: true}
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
        });*/
        $('#password').keyup(function (e) {
            checkPasswordStrength();
        });
        
        $('#phone').keypress(function (e) {
            var regex = new RegExp("^[0-9 \-]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            $("#phoneerror_msg").text("Please Enter Only Digits & Hyphen.").css({"color":"#ff0000","font-size":"13px"})
            setTimeout( function(){$('#phoneerror_msg').hide();} , 2000);;
            e.preventDefault();
            return false;       
        });
    });
    setTimeout(function () {
        $(".alert-danger").hide()
    }, 10000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 10000);

    function checkPasswordStrength() {
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        if($('#password').val().length<6) {
            //$('#password-strength-status').removeClass();
            //$('#password-strength-status').addClass('weak-password');
            $( "#password" ).next('label').text("Weak (should be atleast 6 characters.)");
            $( "#password" ).next('label').show();
        } else {    
            console.log($('#password').val().match(number));
            console.log($('#password').val().match(alphabets));
            console.log($('#password').val().match(special_characters));
            if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
                $( "#password" ).next('label').text('');
                $( "#password" ).next('label').css('display', 'none');
            } else {
               // $('#password-strength-status').removeClass();
                //$('#password-strength-status').addClass('medium-password');
                $( "#password" ).next('label').text("should include alphabets, numbers and special characters.");
                $( "#password" ).next('label').show();
            }
            
        }
    }

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
</script>