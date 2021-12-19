<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo base_url('assets/') ?>images/favicon.png">
        <title><?php echo $page_title ?></title>
        <link href="<?php echo base_url('assets/') ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/fontawesome.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/style.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/responsive.css" rel="stylesheet">
    </head>
    <body>
           
        <div class="fullheight">
            <div class="logowraper">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/setting/').get_themeoption('logo') ?>" alt="" /></a>
            </div>
            <div class="loginwrapper">
                <div class="loginform">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo validation_errors(); ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata("fail")) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail") ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata("notvaliduser")) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("notvaliduser") ?>
                        </div>
                        <?php
                    }
                    ?>

                    <form method="POST" name="singup_form" action="">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="Enter First Name" id="first_name" name="first_name" value="<?php echo set_value('first_name'); ?>"> 
                            <label class="error" for="firstname"></label>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" id="last_name" name="last_name" value="<?php echo set_value('last_name') ?>"> 
                            <label class="error" for="firstname"></label>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" placeholder="Enter User Name" name="user_name" id="user_name" value="<?php echo set_value('user_name'); ?>" > 
                            <label class="error error_msg" for="user_name"></label>
                        </div><?php
                        
                        $email = isset($_GET['user_email'])?$_GET['user_email']:''; $email = ($email)?$email:set_value('email'); ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" value="<?=$email;?>" > 
                            <label class="error" for="email"></label>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Password" name="password" onkeypress="return AvoidSpace(event);">
                            <label class="error" for="password"></label>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password"  class="form-control" placeholder="Confirm Password" name="confirmpassword" onkeypress="return AvoidSpace(event);" value="<?php echo set_value('password'); ?>" id="confirmpassword">
                            <label class="error" for="confirmpassword"></label>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" onkeypress="return AvoidSpace(event);" value="<?=set_value('phone');?>">
                            <label class="error" for="phone"></label>
                            <label id="phoneerror_msg"></label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  id="terms_condition" name="terms_condition" value="1">
                            <label class="form-check-label" for="defaultCheck1">
                               I agree to the<a href="">Terms of Service</a> And <a href="">Privacy Policy</a>
                            </label>
                            <label class="error tearmerror" for="terms_condition"></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="sbmtbtn" id="singup" value="Sign Up">
                        </div>                      
                        <div class="createnew">
                            You have an account ? <a href="<?php echo base_url('login') ?>">Login now </a>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
        <!-- footer start -->
        <footer class="footer loginfooter">
            <div class="copyright">Copyright ©  2020 Org Chart. All rights reserved.</div>
        </footer>
        <!-- footer over -->
        <script src="<?php echo base_url('assets/') ?>js/jquery-3.2.1.min.js"></script> 
        <script src="<?php echo base_url('assets/') ?>js/bootstrap.js"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery_validation.js') ?>"></script>

        <!--Jquery Validation --->
        <script type="text/javascript">
            $(function () {
                $('#singup').click(function(event){
                    //event.preventDefault(); 
                    var first_name = $('#first_name').val();
                    var last_name = $('#last_name').val();
                    var user_name = $('#user_name').val();
                    var email = $('#email').val();
                    var password = $('#password').val();
                    var confirmpassword = $('#confirmpassword').val();
                    var phone = $('#phone').val();
                    var terms_condition = $('#terms_condition').val();
                    var error = 0;

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

                    if($('#terms_condition').prop("checked") == true){ $('.tearmerror').text(''); $('.tearmerror').hide(); }
                    else{ $('.tearmerror').text('This field is required.'); $('.tearmerror').show(); error = 1; }

                    if(error){
                        return false;
                    }else{
                        return true;
                    }
                });

                /*$("form[name='singup_form']").validate({
                    //set Validation rules    
                    rules: {
                        first_name:{required:true},
                        last_name:{required:true},   
                        user_name: {required: true},                    
                        email: {
                            required: true,
                            email: true,
                        },
                        password: { required: true, minimum: 6, format: {
                                pattern: "[a-zA-Z0-9,~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<]+",
                                flags: "i",
                                message: "can only contain a-z and 0-9"
                            }  
                        },
                        confirmpassword: {required: true, equalTo: "#password"},
                        phone:{ required:true},
                        terms_condition:{ required:true}

                    },
                    // Specify validation error messages
                    messages: {
                       confirmpassword: {equalTo: "Password and Confirm Password Does Not matche"}
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
                }); */
            });
            setTimeout(function () {
                $(".alert-danger").hide()
            }, 9000);
            
           /* User Name validation*/
            $('#user_name').keypress(function (e) {
                var regex = new RegExp("^[a-zA-Z0-9]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    return true;
                }
                $(".error_msg").text("Please Enter only Alpha Numeric").css({"color":"#ff0000","font-size":"13px"})
                setTimeout( function(){$('.error_msg').hide();} , 2000);;
                e.preventDefault();
                return false;
            });
    
        </script>

        <script type="text/javascript">
    /* Password Avoid Space */
    function AvoidSpace(event) {        
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) return false;
    }

    /* Phone Number Validation*/
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
    
    $('#password').keyup(function (e) {
        checkPasswordStrength();
    });
    
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
    
    /*$('#singup').click(function(){
        var pass = $('#password').val();
        if(pass == ''){ 
            $( "#password" ).next('label').text("This field is required.");
            return false; 
        }
    });*/
</script>
    </body>
</html>