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
           
            <div class="logowraper">
                <a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/setting/').get_themeoption('logo') ?>" alt="" /></a>
            </div>
            <?php // print_r($_SESSION);?>
            <div class="loginwrapper">
                <div class="loginform">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo validation_errors(); ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata("error_msg")) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("error_msg") ?>
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
        
                    if ($this->session->flashdata("success")) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("success") ?>
                        </div>
                        <?php
                    }
                    if ($this->session->flashdata("fail")) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><i class="fa fa-times-circle" aria-hidden="true"></i></i></strong> <?php echo $this->session->flashdata("fail") ?>
                        </div>
                        <?php
                    }
                    ?> <br />
                    <form method="POST" name="login_form" action="<?php echo base_url('login/validate_login') ?>">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?php echo !empty($this->input->cookie('user_email')) ? $this->input->cookie('user_email', TRUE) : ''; ?>"> 
                            <label class="error" for="email"></label>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo !empty($this->input->cookie('user_password')) ? $this->input->cookie('user_password', TRUE) : ''; ?>" onkeypress="return AvoidSpace(event) ">
                            <label class="error" for="password"></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  id="defaultCheck1" name="remember_me" value="1">
                            <label class="form-check-label" for="defaultCheck1">
                                Remember me
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="sbmtbtn" value="Login">
                        </div>
                        <div class="forgotpassword">
                            <a href="<?php echo base_url('login/forgotpassword') ?>"><i class="fa fa-lock"></i> Forgot your password?</a>
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
                $("form[name='login_form']").validate({
                    //set Validation rules    
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        },
                        password: {
                            required: true
                        }

                    },
                    // Specify validation error messages
                    messages: {
                        email: {
                            required: "Email is required",
                            email: "Please enter valid email",
                        },
                        password: "Password is required"
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
        </script>
    </body>
</html>