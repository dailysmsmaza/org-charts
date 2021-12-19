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
                            <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php
                    if ($this->session->flashdata("fail")) {
                ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata("fail") ?>
                    </div>
                <?php } ?>
                <?php 
                 /* Get Segment*/
                  $secnond_segment = $this->uri->segment(2);
                ?>         
            <div class="whitebox">
                <div class="formwraper">                                            
                    <form method="post" action="" name="user_form" enctype="multipart/form-data">
                                            
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">User Image</label>
                            <div class="col-md-9 col-lg-9 col-xl-10 fileprevwrap">
                                <input type="file" class="form-control" id="user_image" name="user_image"><label class="error" for="user_image"></label>                    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">First Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text"  class="form-control" name="first_name"  id="first_name" value="<?php echo set_value('first_name'); ?>"><label class="error" for="first_name"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Last Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo set_value('last_name'); ?>"><label class="error" for="last_name"></label></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">User Name</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" value="<?php echo set_value('user_name') ?>" name="user_name" id="user_name" class="form-control"><label class="error error_msg" for="user_name"></label></div>
                        </div>   

                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Email</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" name="email" id="email" class="form-control" value="<?php echo set_value('email') ?>"><label class="error" for="email"></label></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Password</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="password" value="<?php echo set_value('password'); ?>" name="password" id="password" class="form-control" onkeypress="return AvoidSpace(event)"><label class="error" for="password"></label></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Confirm Password</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="password" value="<?php echo set_value('password'); ?>" name="confirmpassword" id="confirmpassword" class="form-control"><label class="error" for="confirmpassword"></label></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Phone</label>
                            <div class="col-md-9 col-lg-9 col-xl-10"><input type="text" maxlength="10" name="phone" id="phone" class="form-control" value="<?php echo set_value('phone') ?>"><label class="error" for="phone"></label></div>
                        </div>
                     
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">About</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="about"  class="form-control"><?php echo set_value('about') ?></textarea>
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-3 col-xl-2">Address</label>
                            <div class="col-md-9 col-lg-9 col-xl-10">
                                <textarea name="city" id="city" class="form-control"><?php echo set_value('city') ?></textarea>
                                <label class="error" for="city"></label>
                            </div>
                        </div>                
                        <div class="form-group row">
                            <input  type="submit" name="add_company" id="add_company" value="Add Company">
                        </div>                                  
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
</div>
        <!--Jquery Validation --->
        <?php 
            if($secnond_segment == "add_user"){
        ?>
        <script src="<?php echo base_url('assets/js/') ?>jquery-3.2.1.min.js"></script>                 
    <?php } ?>
<script type="text/javascript">
    $(function () {
        $('#add_company').click(function(event){
            //event.preventDefault(); 
            var user_image = $('#user_image').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var user_name = $('#user_name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmpassword = $('#confirmpassword').val();
            var phone = $('#phone').val();
            var city = $('#city').val();
            var error = 0;

            if(user_image){ $('#user_image').next('label').text(''); $('#user_image').next().hide(); }
            else{ $('#user_image').next('label').text('This field is required.'); $('#user_image').next().show(); error = 1; }

            if(first_name){ $('#first_name').next('label').text(''); $('#first_name').next().hide(); }
            else{ $('#first_name').next('label').text('This field is required.'); $('#first_name').next().show(); error = 1; }

            if(last_name){ $('#last_name').next('label').text(''); $('#last_name').next().hide(); }
            else{ $('#last_name').next('label').text('This field is required.'); $('#last_name').next().show(); error = 1; }

            if(user_name){ $('#user_name').next('label').text(''); $('#user_name').next().hide(); }
            else{ $('#user_name').next('label').text('This field is required.'); $('#user_name').next().show(); error = 1; }

            if(email){ 
                $('#email').next('label').text(''); $('#email').next().hide(); 
                if(!isEmail(email)){
                    $('#email').next('label').text('Please enter valid email address.'); 
                    $('#email').next().show(); error = 1;
                }
            }
            else{ $('#email').next('label').text('This field is required.'); $('#email').next().show(); error = 1; }

            if(password){ 
                $('#password').next('label').text(''); $('#password').next().hide(); 
            }
            else{ $('#password').next('label').text('This field is required.'); $('#password').next().show(); error = 1; }

            if(confirmpassword){ 
                $('#confirmpassword').next('label').text(''); $('#confirmpassword').next().hide(); 
                if(confirmpassword != password){ 
                    $('#confirmpassword').next('label').text('Password and Confirm Password Does Not matche.'); $('#confirmpassword').next('label').show(); error = 1;
                }
            }
            else{ $('#confirmpassword').next('label').text('This field is required.'); $('#confirmpassword').next().show(); error = 1; }

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
               // role: {required: true},
                company: {required: true},
                user_image: {required: true},
                first_name: {required: true},
                last_name: {required: true},
                user_name: {required: true},
                email: {required: true, email: true},
                password: {required: true,minlength: 6},
                confirmpassword: {required: true, equalTo: "#password"},
                phone: {required: true, number: true},               
                city: {required: true}
            },
            // Specify validation error messages
            messages: {
                confirmpassword: {equalTo: "Password and Confirm Password Does Not match"},
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
    });

    /* User Name validation*/
    $('#user_name').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        $(".error_msg").text("Please Enter only Alpha Numeric").css({"color":"#ff0000","font-size":"13px"})
        setTimeout( function(){$('.error_msg').hide();} , 5000);;
        e.preventDefault();
        return false;
    });
    
    setTimeout(function () {
        $(".alert-danger").hide()
    }, 10000);
    setTimeout(function () {
        $(".alert-success").hide()
    }, 10000);

    /* Password Avoid Space */
    function AvoidSpace(event) {        
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) return false;
    }

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
