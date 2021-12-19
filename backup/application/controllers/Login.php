<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("login_model");            
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper('security');
        $this->load->helper('form');
        
    }

    /**
     * Login Form load
     */
    public function index(){
        $data["page_title"] = "ORG Chart | Login";
        $this->load->view('login',$data);
    }

    /**
     * Singup  Form load
     */
    public function singupuser(){
        $user_email = !empty($this->input->post("user_email")) ? $this->input->post("user_email") : "";

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');  
        $this->form_validation->set_rules('user_name', 'User Name', 'required');      
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules('confirmpassword', 'Password and Confirm Password Not match', 'required|matches[password]');
        $this->form_validation->set_rules("phone", "Phone", "required");
        $this->form_validation->set_rules("terms_condition", "Terms And Condition", "required");
        
        if ($this->form_validation->run()) {
            $role = 2;
            $access_level=2;
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");
            $user_name = $this->input->post("user_name");
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $phone = $this->input->post("phone");

            $error = 0;
                   
            /* User Name Validation*/
            if(preg_match("/([%\$#\*@%&()]+)/", $user_name)){
                $this->session->set_flashdata("fail", "User Name Containts Only Alpha Numeric");
                //redirect(base_url("login/companyregister"));
                $error = 1;
            }

            $lowercase = preg_match('#[a-zA-Z]#', $password);
            $number    = preg_match('#[0-9]+#', $password);
            $specialChars = preg_match('#\W+#', $password);

            if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                $error = 1;
            }

            $exist_username = checkcolunm_exist("user_master", "user_name", $this->input->post("user_name"));
            $exist_email = checkcolunm_exist("user_master", "email", $this->input->post("email"));     
            
            if ($exist_username) {
                $this->session->set_flashdata("fail", "User Name Already Exist");
                //redirect("login/companyregister");
                $error = 1;
            }
            if ($exist_email) {
                $this->session->set_flashdata("fail", "Email Already Exist");
               // redirect("login/companyregister");
                $error = 1;
            }

            if($error == 0){

                $data = array('role'=>$role,'access_level'=>$access_level,'first_name' => $first_name, 'last_name' => $last_name,"user_name"=>$user_name,  'email' => $email, 'password' => md5($password), 'phone' => $phone);
                $result = $this->login_model->insert($data);

                if ($result) {                
                    $from    =  get_themeoption("email");                                            
                    $to      = $this->input->post("email");                

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    /*$body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>New User Account</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$_POST["first_name"]." ".$_POST["last_name"]."</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thank you for registering For create Org Chart. You account has now been activated. Please <b><a href='".base_url('login')."' style='text-decoration:none;'>login</a></b> on site and create your Chart.</td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";*/
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$_POST["first_name"]." ".$_POST["last_name"]."</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thank you for registering For create Org Chart. You account has now been activated. Please <b><a href='".base_url('login')."' style='text-decoration:none;'>login</a></b> on site and create your Chart.</td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";
                    
                    $message = $header.$body;
                    //echo $message;exit;
                    send_mail($from,$to,$subject,$message);        
                    /***********************************************************************************************************************
                     *                    SEND Mail To ADMIN OF NEW COMPANY CREATION                                                        * 
                    ************************************************************************************************************************/
                    $from    =  get_themeoption("email");                                            
                    $to      = get_anycolunm_anycondition("user_master","email","id",1);

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>New User Account</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi,"."&nbsp; Admin</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>New compnay  " .$_POST['first_name']."  ".$_POST['last_name']." created in your Website. Please <b><a href='".base_url('login')."' style='text-decoration:none;'>login</a></b> on back-end and check details of compnay.</td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";

                    $message = $header.$body;

                    send_mail($from,$to,$subject,$message);     

                    $this->session->set_flashdata("success", "Account Successfully Created");
                    redirect(base_url("login"));
                }
            } else {
                //$this->session->set_flashdata("fail", "User Not  Add Successfully");
                //redirect("login/singup");
            }            
        }

        $data["page_title"] = "ORG Chart | Singup";
        $data["user_email"] = $user_email;
        $this->load->view('singup',$data);
    }

    /*
     * Register Company 
    */
    public function companyregister(){
            
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');  
        $this->form_validation->set_rules('user_name', 'User Name', 'required');      
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules('confirmpassword', 'Password and Confirm Password Not match', 'required|matches[password]');
        $this->form_validation->set_rules("phone", "Phone", "required");
        $this->form_validation->set_rules("terms_condition", "Terms And Condition", "required");
        
        if ($this->form_validation->run() == FALSE) {
            $user_email = !empty($this->input->post("user_email")) ? $this->input->post("user_email") : "";       
            $data["page_title"] = "ORG Chart | Singup";
            $data["user_email"] = $user_email;
            $this->load->view('singup',$data);         
            
        } else {            
            $role = 2;
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");
            $user_name = $this->input->post("user_name");
            $email = $this->input->post("email");
            $password = md5($this->input->post("password"));
            $phone = $this->input->post("phone");

            $error = 0;
                   
            /* User Name Validation*/
            if(preg_match("/([%\$#\*@%&()]+)/", $user_name)){
                $this->session->set_flashdata("fail", "User Name Containts Only Alpha Numeric");
                //redirect(base_url("login/companyregister"));
                $error = 1;
            }  

            if(strlen($_POST['password'])<6){
                $this->session->set_flashdata("fail","Please enter at least 6 characters Password.");
                //redirect(base_url("login/companyregister"));
                $error = 1;
            }

            $exist_username = checkcolunm_exist("user_master", "user_name", $this->input->post("user_name"));
            $exist_email = checkcolunm_exist("user_master", "email", $this->input->post("email"));     
            
            if ($exist_username) {
                $this->session->set_flashdata("fail", "User Name Already Exist");
                //redirect("login/companyregister");
                $error = 1;
            }
            if ($exist_email) {
                $this->session->set_flashdata("fail", "Email Already Exist");
               // redirect("login/companyregister");
                $error = 1;
            }

            if($error == 0){

                $data = array('role'=>$role,'first_name' => $first_name, 'last_name' => $last_name,"user_name"=>$user_name,  'email' => $email, 'password' => $password, 'phone' => $phone);
                $result = $this->login_model->insert($data);

                if ($result) {                
                    $from    =  get_themeoption("email");                                            
                    $to      = $this->input->post("email");                

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>New User Account</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$_POST["first_name"]." ".$_POST["last_name"]."</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thank you for registering For create Org Chart. You account has now been activated. Please <b><a href='".base_url('login')."' style='text-decoration:none;'>login</a></b> on site and create your Chart.</td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";

                    $message = $header.$body;

                    send_mail($from,$to,$subject,$message);        
                    /***********************************************************************************************************************
                     *                    SEND Mail To ADMIN OF NEW COMPANY CREATION                                                        * 
                    ************************************************************************************************************************/
                    $from    =  get_themeoption("email");                                            
                    $to      = get_anycolunm_anycondition("user_master","email","id",1);

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>New User Account</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi,"."&nbsp; Admin</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>New compnay  " .$_POST['first_name']."  ".$_POST['last_name']." created in your Website. Please <b><a href='".base_url('login')."' style='text-decoration:none;'>login</a></b> on back-end and check details of compnay.</td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";

                    $message = $header.$body;

                    send_mail($from,$to,$subject,$message);     

                    $this->session->set_flashdata("success", "Account Successfully Created");
                    redirect(base_url("login"));
                }
            } else {
                $this->session->set_flashdata("fail", "User Not  Add Successfully");
                redirect("login/singup");
            }            
        }
    }

    /*Validate Login*/
    public function validate_login(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE){
            $data["page_title"] = "ORG Chart | Login";
            $this->load->view('login',$data);
        }
        else{
            $email      = $this->input->post("email");
            $password   = md5($this->input->post("password"));
            $remember   = $this->input->post("remember_me");
            if($remember == 1){
                $this->input->set_cookie("user_email",$email,'3600');
                $this->input->set_cookie("user_password",$password,'3600');                
            }
            $result     = $this->login_model->validate_login($email,$password);
            if($result){
                if($this->session->userdata('role') == 1){
                    $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                      redirect('login/dashboard');
                }else if ($this->session->userdata('role') == 2) {
                    $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                    redirect('login/dashboard');
                }else if ($this->session->userdata('role') == 3) {
                    $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                    redirect('login/dashboard');
                }else{
                    $this->session->set_flashdata("notvaliduser","You are not valid user");
                     redirect('login');
                }
                 
                /* if($this->session->userdata('access_level') == 0){
                $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                    redirect('login/dashboard');
                }else if ($this->session->userdata('access_level') == 1) {
                    $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                    redirect('login/dashboard');
                }else if ($this->session->userdata('access_level') == 2) {
                    $this->session->set_flashdata("success","Welcome"."  ".get_anycolunm("user_master","first_name",$this->session->userdata("id"))." ".get_anycolunm("user_master","last_name",$this->session->userdata("id")));
                    redirect('login/dashboard');
                }else{
                    $this->session->set_flashdata("notvaliduser","You are not valid user");
                     redirect('login');
                }
                */

            }else{
                $this->session->set_flashdata("error_msg","Email or Password is invalid");
                redirect("login");
            }
        }
    }

    /*Admin Dashboard Load*/
    public function dashboard(){
        if($this->session->userdata("id")==""){ redirect("login");} 
        $data["page_title"] = "ORG Chart | Admin Dashboard";   
        $data["heading_title"] = "Dashboard";
        $this->load->view("admin/include/header",$data);
        $data["total_record"] = $this->login_model->get_totalrecord("user_master","role",2);
        $this->load->view("admin/dashboard",$data);
        $this->load->view("admin/include/footer");
    }

    /*
     * User Profile
    */
    public function user_profile($id){
        if($this->session->userdata("id")==""){ redirect("login");} 
        $data["page_title"] = "ORG Chart | User Profile";   
        $data["heading_title"] = "Dashboard";
        $this->load->view("admin/include/header",$data);
        $data["user_profile"] = $this->login_model->user_profile($id);
        $this->load->view("admin/profile/user_profile",$data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Edit User Profile
    */
    public function edit_profile($id){
        if($this->session->userdata("id")==""){ redirect("login");} 
        $data["page_title"] = "ORG Chart | Edit Profile";   
        $data["heading_title"] = "Dashboard";

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules("email", "Email", "required|valid_email");        
        $this->form_validation->set_rules("phone", "Phone", "required|numeric");        
        if($this->session->userdata("role") == 3){
            $this->form_validation->set_rules("designation", "Designation", "required");
            $this->form_validation->set_rules("skill", "Skill", "required");
        }            
        $this->form_validation->set_rules("city", "City", "required");

        if ($this->form_validation->run() == FALSE) {
        }else {
            if (!empty($_FILES["user_image"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);
                $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');
            } else {
                $filename = $this->input->post("old_user_image");
            }
           
            $company = $this->input->post("company");
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");              
            $email     = $this->input->post("email");
            $phone = $this->input->post("phone");
            if($this->session->userdata("role") == 3){
                $designation = $this->input->post("designation");
                $skill = $this->input->post("skill");
            }
            $password = $this->input->post("password");
            $about = $this->input->post("about");            
            $city = $this->input->post("city");
            
            /* Check Email Exist */
            $query = $this->db->query("Select id,email from user_master");
            $res = $query->result_array();
            $no = $query->num_rows();
            if ($res) {
                foreach ($res as $key => $value) {
                    if ($value["id"] != $id) {
                        if ($email == $value['email']) {
                            $this->session->set_flashdata("fail", "Email Already Exist");
                            redirect("user/edit/" . $id);
                        }
                    }
                }
            }
           if($this->session->userdata("role") == 3){
                $data = array("user_image"=>$filename,'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'phone' => $phone, 'designation'=>$designation ,'skill'=>$skill, 'about' => $about,  'city' => $city);

                if($password){
                    $data['password'] = md5($password);
                }
               //print_r($data);exit(); 

            }else{
                $data = array('company'=>$company,"user_image"=>$filename,'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'phone' => $phone,  'about' => $about,  'city' => $city);
                if($password){
                    $data['password'] = md5($password);
                }
            }

            $result = $this->login_model->update_userprofile($data,$id);
            if ($result) {
                $this->session->set_flashdata("success", "User Profile Update Successfully");
                redirect("login/user_profile/".$id);
            } else {
                $this->session->set_flashdata("fail", "User Profile Not  Update Successfully");
                redirect("login/edit_profile".$id);
            }
        }
        $this->load->view("admin/include/header",$data);
        $data["edit_profile"] = $this->login_model->user_profile($id);
        $this->load->view("admin/profile/edit_profile",$data);
        $this->load->view("admin/include/footer");
    }

     /*
     * Image Upload Do Upload
     */

    function do_upload($control, $filename, $upload_path, $file_format) {
        $config['upload_path'] = $upload_path;
        $config['file_name'] = $filename;
        $config['allowed_types'] = $file_format;
        $config['remove_spaces'] = FALSE;
        $config['max_size'] = '0';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($control)) {
            echo $this->upload->display_errors();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /*
     * Forgot Password
    */
    public function forgotpassword(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
        }else{
            $email = $this->input->post("email");
            $result = checkcolunm_exist("user_master", "email", $this->input->post("email"));
            if($result){

                $key = md5(microtime().rand());
                $this->db->where('email', $email);
                $this->db->update('user_master', array('reset_key' => $key));

                    $user_info = get_anytwocolunm_anycondition("user_master","first_name","last_name","email",$email);
                    $from    =  get_themeoption("email");                                            
                    $to      = $email;
                    $subject = " RESET Password - Org Chart";

                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Forgot Password</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Reset Password</h4></td><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi,"."&nbsp;".$user_info['first_name']."  ".$user_info['last_name']."</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Please click on below link and Reset Your Password and Login with Your New Password.</td><tr><td ><a href='".base_url('login/resetpassword/'.$key)."' style='text-decoration:none;'><b>RESET PASSWORD</b></a></td>
                                    </tr><tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";

                   $message = $header.$body;
                    send_mail($from,$to,$subject,$message);     
                    $this->session->set_flashdata("success", "Mail Send Successfully");
                    redirect(base_url("login"));
                } else {
                    $this->session->set_flashdata("fail", "Your Email Address Is Not Registered");
                    redirect(base_url("login/forgotpassword"));
                }                  
            }
            $data["page_title"] = "ORG Chart | Forgot Password";        
            $this->load->view('forgotpassword',$data);
        }
        

    /*
     * Reset Password
    */
    public function resetpassword($key = ''){
        if($key == ''){ redirect(base_url("login")); }
        $query = $this->db->query("SELECT * FROM user_master WHERE reset_key = '".$key."'");
        $row = $query->row();
        if($row){}else{ redirect(base_url("login")); }

        //$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Password and Confirm Password Not match', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
        }else{

            //$result = checkcolunm_exist("user_master", "email", $this->input->post("email"));
            if($row){

                $password = $_POST['password'];
                $lowercase = preg_match('#[a-zA-Z]#', $password);
                $number    = preg_match('#[0-9]+#', $password);
                $specialChars = preg_match('#\W+#', $password);

                if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                    $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                }else{
                    $password = md5($this->input->post("password"));
                    $data = array("password"=>$password, 'reset_key' => '');
                    $this->db->where("id",$row->id);
                    $result = $this->db->update("user_master",$data);
                    if($result){
                        $this->session->set_flashdata("success", "Your Password Is Reset Successfully");
                        redirect(base_url("login"));
                    }
                }
            }else{
                $this->session->set_flashdata("fail", "Your Email Address Is Not Registered");
                redirect(base_url("login"));
            }                
        }
        $data["page_title"] = "ORG Chart |  Reset Password";
        $this->load->view('resetpassword',$data);
    }

    /*Logout*/
    public function logout(){
       $this->session->unset_userdata('id');
       $this->session->unset_userdata('role');
       $this->session->unset_userdata('username');
       $this->session->unset_userdata('company');
       $this->session->sess_destroy();
       redirect("login");
    }
}
