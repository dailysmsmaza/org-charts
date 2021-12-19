<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo base_url('assets/setting/').get_themeoption('favicon') ?>">
        <title><?php echo $page_title ?></title>
        <link href="<?php echo base_url('assets/') ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/fontawesome.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/style.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/') ?>css/responsive.css" rel="stylesheet">
    </head>
    <body>
        <div class="fullheight">
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
            if ($this->session->flashdata("success")) {
                ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success") ?>
                </div>
                <?php
            }           
            ?>       
            <div class="logowraper">
                <img src="<?php echo base_url('assets/setting/').get_themeoption('logo') ?>" alt="" />
            </div>
            <div class="loginwrapper">
                <div class="loginform">
                    <form method="POST" name="resetpassword_form" action="">
                        <!-- <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email"> 
                            <label class="error" for="email"></label>
                        </div> -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" onkeypress="return AvoidSpace(event) ">
                            <label class="error" for="password"></label>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" onkeypress="return AvoidSpace(event) ">
                            <label class="error" for="confirmpassword"></label>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="sbmtbtn" id="sbmtbtn" value="Reset Password">
                        </div>
                        <div class="createnew">
                            You have an account ? <a href="<?php echo base_url('login') ?>">Login now </a>
                        </div>
                        <div class="createnew">
                            Don't have an account ? <a href="<?php echo base_url('signup') ?>">Signup now </a>
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
                $('#password').keyup(function (e) {
                    checkPasswordStrength();
                });

                $('#sbmtbtn').click(function(event){
                    //event.preventDefault(); 
                    var password = $('#password').val();
                    var confirmpassword = $('#confirmpassword').val();
                    var error = 0;

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

                    if(error){
                        return false;
                    }else{
                        return true;
                    }
                });

                /*$("form[name='resetpassword_form']").validate({
                    rules: {
                        email:{ required:true,email:true},
                        password: {
                            required: true
                        },
                        confirmpassword:{
                            required:true,
                            equalTo:"#password"
                        }

                    },
                    // Specify validation error messages
                    messages: {
                        password:{
                            required:"Password is required",  
                        } ,
                        confirmpassword:{
                            required:"Confirm Password is required",
                            equalTo:"Password and Confirm Password Not Match"
                        }
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
            });
           setTimeout(function () {
                $(".alert-danger").hide()
            }, 9000);
            setTimeout(function () {
                $(".alert-success").hide()
            }, 9000);

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
    </body>
</html>