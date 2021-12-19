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
                <img src="<?php echo base_url('assets/setting/').get_themeoption('logo') ?>" alt="" />
            </div>
            <div class="loginwrapper">
                <div class="loginform">
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo validation_errors(); ?>
                        </div>
                    <?php
                    }
                    if ($this->session->flashdata("fail")) {
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </strong> <?php echo $this->session->flashdata("fail") ?>
                        </div>
                    <?php
                    }          
                    if ($this->session->flashdata("success")) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <?php echo $this->session->flashdata("success") ?>
                        </div>
                        <?php
                    }           
                    ?>
            
                    <form method="POST" name="forgotpassword_form" action="<?php echo base_url('login/forgotpassword') ?>">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" > 
                            <label class="error" for="email"></label>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="sbmtbtn" value="Get Password">
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
                $("form[name='forgotpassword_form']").validate({
                    //set Validation rules    
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        }

                    },
                    // Specify validation error messages
                    messages: {
                        email: {
                            required: "Email is required",
                            email: "Please enter valid email",
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
                });
            });
           setTimeout(function () {
                $(".alert-danger").hide()
            }, 3000);
            setTimeout(function () {
                $(".alert-success").hide()
            }, 3000);
        </script>
    </body>
</html>