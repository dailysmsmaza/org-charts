<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->model("user_model");
        $this->load->model("company_model");
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");     
        $this->load->library('pagination');        
        if ($this->session->userdata('id')=="") {
            redirect("login");
        }        

    }

    /**
     * User List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | User";
        $data["heading_title"] = "Users List";
            
        $page_num = "";
        $this->load->view("admin/include/header",$data);
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        if ($search != "") {
            $page_num = isset($_GET["per_page"]) ? $_GET["per_page"] : "";
            $config['base_url'] = base_url()."user/index?search=".$search;
            $condition = " where first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%' and  role = 1 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            $config['page_query_string'] = TRUE;
            $config['enable_query_strings'] = TRUE;

            $data["total_user"] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query(); 
        }else{           
            $page_num = $this->uri->segment(3);
            $config['base_url'] = base_url()."user/index";
            $condition = " where role =1 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query();
            $data["total_user"] = get_totalnumber_of_rows("user_master",$condition);;
        }
        
       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["user_list"] = $this->user_model->get_user_list($search,$config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/user/user_list', $data);
        $this->load->view("admin/include/footer");
    }
    
    /*
     * User Proile
     */
    public function user_profile($id){
        $data["page_title"] = "ORG Chart | User Profile";
        $data["user_profile"] = $this->user_model->get_user_profile($id);
        $this->load->view('admin/user/user_profile', $data);
    }

    /*
     * Add User
     */
    public function add_user() {
        $data["page_title"] = "ORG Chart | Add User";
        $data["heading_title"] = "Add User";
        $data["company"] = $this->company_model->get_company_list();
        $this->load->view("admin/include/header",$data);
            
        if (empty($_FILES["user_image"]["name"])) {
            $this->form_validation->set_rules('user_image', 'User Image', 'required');
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules('confirmpassword', 'Password and Confirm Password Not match', 'required|matches[password]');
        $this->form_validation->set_rules("phone", "Phone", "required");
                
        $this->form_validation->set_rules("city", "City", "required");
        if ($this->form_validation->run()){
            $password = $this->input->post("password");
            $lowercase = preg_match('#[a-zA-Z]#', $password);
            $number    = preg_match('#[0-9]+#', $password);
            $specialChars = preg_match('#\W+#', $password);

            if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                $error = 1;
                //redirect(base_url("user/add_user"));
            }else{
                if (!empty($_FILES["user_image"]["name"])) {
                    $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);
                    $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');
                } else {
                    $filename = '';
                }
                $role = 1;

                $first_name = $this->input->post("first_name");
                $last_name = $this->input->post("last_name");
                $user_name = $this->input->post("user_name");
                $email = $this->input->post("email");
                $password = md5($this->input->post("password"));
                $phone = $this->input->post("phone");            
                $about = $this->input->post("about");                
                $city = $this->input->post("city");
                $error = 0;
                $exist_email = checkcolunm_exist("user_master", "email", $email);            

                if ($exist_email) {
                    $this->session->set_flashdata("fail", "Email Already Exist");
                    //redirect(base_url("user/add_user"));
                    $error = 1;
                }

                if($error == 0){
                    $data = array('role'=>$role,"user_image"=>$filename,'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'password' => $password, 'phone' => $phone, 'about' => $about,  'city' => $city);
                    $result = $this->user_model->insert($data);
                    if ($result) {
                        $this->session->set_flashdata("success", "User Add Successfully");
                        redirect("user");
                    } else {
                        $this->session->set_flashdata("fail", "User Not  Add Successfully");
                        //redirect("user/add_user");
                    }
                }
            }            
        }
        $this->load->view('admin/user/add_user', $data);
        $this->load->view("admin/include/footer");
    }
    /*
     * Edit User
     */
    public function edit($id) {


        $data["page_title"] = "ORG Chart | Edit User";
        $data["heading_title"] = "Edit User";
                
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        //$this->form_validation->set_rules("password", "password", "required");
        
        $this->form_validation->set_rules("phone", "Phone", "required");       
        //$this->form_validation->set_rules("city", "City", "required");
        if ($this->form_validation->run() == FALSE) {
           
            
        } else {
            $error = 0;
            if($_POST["password"]){
                $password = $this->input->post("password");
                $lowercase = preg_match('#[a-zA-Z]#', $password);
                $number    = preg_match('#[0-9]+#', $password);
                $specialChars = preg_match('#\W+#', $password);

                if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                    $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                    //redirect(base_url("user/edit/".$id));
                    $error = 1;
                }
            }
            if (!empty($_FILES["user_image"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);
                $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');
            } else {
                $filename = $this->input->post("old_user_image");
            }
           
            //$company = $this->input->post("company");
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");              
            $email     = $this->input->post("email");
            $phone = $this->input->post("phone");
           // $designation = $this->input->post("designation");
            $about = $this->input->post("about");
           //$skill = $this->input->post("skill");
            $city = $this->input->post("city");

            $password = $this->input->post("password");
            
            /* Check Email Exist */
            $query = $this->db->query("Select id,email from user_master");
            $res = $query->result_array();
            $no = $query->num_rows();
            if ($res) {
                foreach ($res as $key => $value) {
                    if ($value["id"] != $id) {
                        if ($email == $value['email']) {
                            $this->session->set_flashdata("fail", "Email Already Exist");
                            //redirect("user/edit/" . $id);
                            $error = 1;
                        }
                    }
                }
            }
           //    echo $password;exit;
            if($error == 0){
                $data = array("user_image"=>$filename,'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'phone' => $phone,  'about' => $about,  'city' => $city);
                $result = $this->user_model->update($data,$id);
                    
                    //jc
                if ($result) {      


                    $from    =  get_themeoption("email");                                            
                   // $to      = $this->input->post("email");  
                    $to = $email;              

                    $subject = "Account Successfully Updated - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                 
                    $body   =  "<body>
                                    <table cellspacing='0' cellpadding='0' align='center' border='0' style='width:600px;background-color:#8080800f;margin:0 auto;'>
                                         <tr style='display:block;'><td style='display:inherit;border:1px solid #eaedf3;font-weight:200;height:225px;'><table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'><tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$first_name." ".$last_name."</td></tr><tr>
                                            <td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Your account has been updated in <b>Org Charts</b>.</td></tr>
                                            <tr><td>Username : ".$email."</td></tr>
                                    <tr><td>Password : ".$password."</td></tr>
                                            <tr><td>
                                            Please click <a href='".base_url('login')."' style='text-decoration:none;'>here</a> to Login. </td>
                                    </tr>
                                    <tr></tr>
                                    <tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></table></body></html>";
                    
                    $message = $header.$body;

                   //echo $message;exit;
                    //echo $from."--".$to;exit;
                    send_mail($from,$to,$subject,$message);        
              

                }
                if ($result) {
                    $this->session->set_flashdata("success", "User Update Successfully");
                    redirect("user");
                } else {
                    $this->session->set_flashdata("fail", "User Not  Update Successfully");
                    //redirect("user/edit");
                }
            }
        }
        $this->load->view('admin/include/header',$data);
        $data["edit_user"] =$this->user_model->edit($id);
        $this->load->view('admin/user/edit_user', $data);
        $this->load->view('admin/include/footer');
    }

    /*
     * Change Status
     */

    public function changestatus($status, $id) {
        $data = array('status' => $status);
        $result = $this->user_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "User Status Update Successfully");
            redirect("user");
        } else {
            $this->session->set_flashdata("fail", "User Status Not  Update Successfully");
            redirect("user");
        }
    }

    /*
     * Delete User
     */

    public function delete($id) {
        $result = $this->user_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "User Delete Successfully");
            redirect("user");
        } else {
            $this->session->set_flashdata("fail", "User Not  Delete Successfully");
            redirect("user");
        }
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

}
