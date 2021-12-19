<?php error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("employee_model");
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");
        $this->load->library('pagination');
        if ($this->session->userdata('id') == "") {
            redirect("login");
        }
        
        $access_level = $this->session->userdata("access_level");
        $role=$this->session->userdata("role");
        if(($access_level!=2))
        {
           redirect("login/dashboard");
        }
    }

    /**
     * Empployee List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | Employee";
        $data["heading_title"] = "Employee List";
        $this->load->view("admin/include/header", $data);
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company = $this->session->userdata('company');
        }else{
          $company = $this->session->userdata('id');
        } 
        //$company =  $this->session->userdata("id");
        $page_num = "";
        $condition = "";
        
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $department=isset($_GET["department"]) ? $_GET["department"] : "";
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;

        $page_num = ($this->uri->segment(3)!="") ? $this->uri->segment(3) : "0";
            
        $condition = " where company='$company' and role=3 and is_delete=0";
        if($department!=''){
            $condition.= " and (department_id = $department)"; 
         }
        $config['base_url'] = base_url('/employee/index');
        $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);   
        $data["total_employee"] =  get_totalnumber_of_rows("user_master",$condition);   
        $data["employee_list"] = $this->employee_model->get_employee_list($department,$search,$company, $config["per_page"], $page_num);
        $data["company"] = $this->employee_model->get_company_list();
        $this->pagination->initialize($config);
        $this->load->view('admin/employee/employee_list', $data);
        $this->load->view("admin/include/footer");
    }


    /*
     * Add Empployee
     */
    public function add_employee() {
        $data["page_title"] = "ORG Chart | Add Employee";
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        $user_id = $this->session->userdata("id");
        if($role==2 && $access_level==2){
         $companyid = $this->session->userdata("id");
        }elseif ($role==3 && $access_level==2) {
          $companyid = $this->session->userdata("company");
        }else{
          $companyid = $this->session->userdata("id");
        } 
        
        $company   =  get_userinfo($companyid,"first_name","last_name");
        $data["heading_title"] = "Add Employee ".$company["first_name"]." ".$company["last_name"];
        $this->load->view("admin/include/header",$data);        
        
        if (empty($_FILES["user_image"]["name"])) {
            $this->form_validation->set_rules('user_image', 'User Image', 'required');
        }
        $this->form_validation->set_rules('access_level', 'Access', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        
        $this->form_validation->set_rules("phone", "Phone", "");
        $this->form_validation->set_rules("designation", "Designation", "required");
        
        $this->form_validation->set_rules("skill", "Skill", "");
        $this->form_validation->set_rules("city", "City", "");
        $this->form_validation->set_rules("department_id", "Department", "");
        $this->form_validation->set_rules("start_date", "Start Date", "");

        if ($this->form_validation->run()) {
            if (!empty($_FILES["user_image"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);
                $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');
            } else {
                $filename = '';
            }

              if($role==2 && $access_level==2){
                 $company = $this->session->userdata("id");
               }elseif ($role==3 && $access_level==2) {
                 $company = $this->session->userdata("company");
               }else{
                  $company = $this->session->userdata("id");
               } 
            //$company = $this->session->userdata("id");
            $role = 3;
            
            $access_level = $this->input->post("access_level");
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");
            $email = $this->input->post("email");
            //jc
            $password = $this->input->post("password");
            $phone = $this->input->post("phone");
            $designation = $this->input->post("designation");
            $about = $this->input->post("about");
            $skill = $this->input->post("skill");
            $city = $this->input->post("city");
            $department_id = $this->input->post("department_id");
            $start_date = $this->input->post("start_date");
            $start_date = ($start_date)?date('Y-m-d', strtotime($start_date)):'';
            $parent_employee = $this->input->post("parent_employee"); 
            $error = 0;          

            $exist_email = checkcolunm_exist("user_master", "email", $email);
           
            if ($exist_email) {
                $this->session->set_flashdata("fail", "Email Already Exist");
                //redirect("employee/add_employee");
                $error = 1;
            }

            if($error == 0){
                $data = array('role' => $role, 'company' => $company, "user_image" => $filename,'access_level' => $access_level, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email,'password'=>md5($password), 'phone' => $phone, 'designation' => $designation, 'about' => $about, 'skill' => $skill, 'city' => $city, 'department_id' => $department_id, 'start_date' => $start_date,'usr_createddate' => current_datetime(),'usr_createdby' =>$user_id);
                $result = $this->employee_model->insert($data);

                //jc
                 if ($result) {          
                          // this is for parent employee
                          $insertid = $this->db->insert_id();
                    // print_r($insertid);
                    // exit();
                    if($insertid){
                        if($parent_employee){
                            $query = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$parent_employee);
                            $row = $query->row();
                            $cdata = array('company_id' => $companyid, 'item_id' => $insertid, 'parent_id' => $parent_employee,'depth' => ($row)?($row->depth + 1):1);
                            $this->db->insert("employee_short",$cdata);

                            //Department
                            if($department_id){
                                $query2 = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$parent_employee);
                                $row2 = $query2->row();
                                $dpdata = array('company_id' => $company, 'department_id' => $department_id, 'item_id' => $insertid, 'parent_id' => $parent_employee,'depth' => ($row2)?($row2->depth + 1):1);
                                $this->db->insert("department_employee_short",$dpdata);
                            }
                        }
                    }
                    // this is for parent employee
                    $from    =  get_themeoption("email");                                            
                    $to      = $this->input->post("email");                

                    $subject = "Account Successfully Created - Org Chart";
                    $header  = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html lang=''><head><meta http-equiv='x-ua-compatible' content='IE=edge'><meta http-equiv='content-type' content='text/html; charset=utf-8'><title>ORG Chart Account Succefully Creation</title><link href='https://fonts.googleapis.com/css?family=Work+Sans:700&amp;display=swap' rel='stylesheet'><style type='text/css'>body{ margin:0;padding:0;background-color:#fafbfc;}</style></head>";
                    $emailbody="<body><table cellspacing='0' cellpadding='0' align='center' border:1px solid #eaedf3; style='width:600px;background-color:#8080800f;margin:0 auto;'>";
                   $emailbody.="<tr style='display:block;'><td style='display:block;'><h4 style='font-family:Work Sans,sans-serif;font-weight:700;font-size:20px;color:#3e3f42;margin-top:27px;margin-bottom:27px;text-align:center;'>Account Succefully Created -  Orgchart</h4></td><td style='display:inherit;font-weight:200;height:340px;'>";
                   
                    $emailbody.="<table cellspacing='0' cellpadding='0' border='0' style='max-width:530px;width:100%;margin:0 auto;padding:0 15px;height:225px;'>";

                    // here start email body
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Hi ,"."&nbsp;".$_POST["first_name"]." ".$_POST["last_name"]."</td></tr>";
                    
                    $emailbody.="<tr><td>&nbsp;</td></tr>";

                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Your account has been created in Org Charts</td></tr>";
                    
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Username : ".$_POST["email"]."</td></tr>";
                    $emailbody.="<tr><td style='display:block;font-size:15px; font-family:Arial;color:#000000;'>Password : ".$_POST["password"]."</td></tr>";

                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;margin-top:28px;margin-bottom:0px;font-family:Arial;color:#000000;'>Please <a href='".base_url('login')."' style='text-decoration:none;'>login</a> and give your feedback</td></tr>";

                    $emailbody.="<tr><td>&nbsp;</td></tr>";
                    $emailbody.="<tr><td style='display:block;font-size:15px;line-height:24px;font-family:Arial;color:#000000;'>Thanks,<br>Org Chart Team</td></tr>";
                    // Here end email body

                    $emailbody.="</table>";

                    $emailbody.="</td></tr>";
                    $emailbody.="</table></body></html>";

                    $message = $header.$emailbody;
                    // echo $message;
                    //  exit;
                    send_mail($from,$to,$subject,$message);                
                   
                    $this->session->set_flashdata("success", "Account Successfully Created");
                    redirect(base_url("employee"));
                }
            } else {
                //$this->session->set_flashdata("fail", "User Not  Add Successfully");
                //redirect("login/singup");
            }

               /* if ($result) {
                    $insertid = $this->db->insert_id();
                    // print_r($insertid);
                    // exit();
                    if($insertid){
                        if($parent_employee){
                            $query = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$parent_employee);
                            $row = $query->row();
                            $cdata = array('company_id' => $companyid, 'item_id' => $insertid, 'parent_id' => $parent_employee,'depth' => ($row)?($row->depth + 1):1);
                            $this->db->insert("employee_short",$cdata);

                            //Department
                            if($department_id){
                                $query2 = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$parent_employee);
                                $row2 = $query2->row();
                                $dpdata = array('company_id' => $company, 'department_id' => $department_id, 'item_id' => $insertid, 'parent_id' => $parent_employee,'depth' => ($row2)?($row2->depth + 1):1);
                                $this->db->insert("department_employee_short",$dpdata);
                            }
                        }
                    }

                    $this->session->set_flashdata("success", "Empployee Add Successfully");
                    redirect("employee");
                } else {
                    $this->session->set_flashdata("fail", "Empployee Not  Add Successfully");
                    //redirect("employee/add_employee");
                }*/
            
        }


        $this->load->view('admin/employee/add_employee', $data);
        $this->load->view('admin/include/footer');
    }

    /*
     * Edit Empployee
     */
    public function edit($id) {
        $data["page_title"] = "ORG Chart | Edit Employee";
        $data["heading_title"] = " Edit Employee";
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        $user_id=$this->session->userdata("id");
        if($role==2 && $access_level==2){
         $companyid = $this->session->userdata("id");
        }elseif ($role==3 && $access_level==2) {
          $companyid = $this->session->userdata("company");
        }else{
          $companyid = $this->session->userdata("id");
        } 
        
        $this->load->view("admin/include/header", $data);
        $this->form_validation->set_rules('access_level', 'Access ', '');        
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules("phone", "Phone", "");
        $this->form_validation->set_rules("designation", "Designation", "required");
        $this->form_validation->set_rules("skill", "Skill", "");
        $this->form_validation->set_rules("city", "City", "");
        $this->form_validation->set_rules("department_id", "Department", "");
        $this->form_validation->set_rules("start_date", "Start Date", "");

        if ($this->form_validation->run() == FALSE) {
        } else {

            if (!empty($_FILES["user_image"]["name"])) {

                $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);

                $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');

            } else {

                $filename = $this->input->post("old_user_image");

            }

            if($role==2 && $access_level==2){
             $company = $this->session->userdata("id");
            }elseif ($role==3 && $access_level==2) {
             $company = $this->session->userdata("company");
            }else{
             $company = $this->session->userdata("id");
            }

            $access_level = $this->input->post("access_level");
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");
            $email = $this->input->post("email");
            //jc
            $password = $this->input->post("password");
            $phone = $this->input->post("phone");
            $designation = $this->input->post("designation");
            $about = $this->input->post("about");
            $skill = $this->input->post("skill");
            $city = $this->input->post("city");
            $parent_employee = $this->input->post("parent_employee"); 
            $department_id = $this->input->post("department_id");
            $start_date = $this->input->post("start_date");
            $start_date = ($start_date)?date('Y-m-d', strtotime($start_date)):'';
            $error = 0;            

            /* Check Email Exist */

            $query = $this->db->query("Select id,email from user_master");
            $res = $query->result_array();
            $no = $query->num_rows();
            if ($res) {

                foreach ($res as $key => $value) {
                    if ($value["id"] != $id) {
                        if ($email == $value['email']) {
                            $this->session->set_flashdata("fail", "Email Already Exist");
                            //redirect("employee/edit/" . $id);
                            $error = 1;
                        }
                    }
                }
            }

            if($error == 0){
                $data = array('company' => $company, "user_image" => $filename, 'access_level' => $access_level,'first_name' => $first_name, 'last_name' => $last_name,'email' => $email,'phone' => $phone, 'designation' => $designation, 'about' => $about, 'skill' => $skill, 'city' => $city, 'department_id' => $department_id, 'start_date' => $start_date, 'usr_updateddate' => current_datetime(),'usr_updatedby' =>$user_id);
             
                  
                $result = $this->employee_model->update($data, $id);
                
                if($password!=''){
                    $datapassword = array('password' => md5($password));
                    $resultpassword = $this->employee_model->update($datapassword, $id);
                }
    
                if ($result) {
                    // echo $parent_employee;
                        // exit;
                        $query = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$parent_employee);
                        $row = $query->row();

                        $equery = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$id);
                        $erow = $equery->row();                        

                        $edepth = ($erow)?$erow->depth:1;
                        $depth = ($row)?($row->depth + 1):$edepth;
                        $cdata = array('company_id' => $companyid, 'item_id' => $id, 'parent_id' => $parent_employee,'depth' => $depth);
                       
                        if($erow){
                            $this->db->where("id", $erow->id);
                            $this->db->update("employee_short",$cdata);
                        }else{
                            $this->db->insert("employee_short",$cdata);
                        }

                        //Department
                        if($department_id){
                            $dpquery = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$parent_employee);
                            $dprow = $dpquery->row();

                            $dpequery = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$id);
                            $dperow = $dpequery->row();                        

                            $dpedepth = ($dperow)?$dperow->depth:1;
                            $dpdepth = ($dprow)?($dprow->depth + 1):$dpedepth;
                            $dpcdata = array('company_id' => $companyid, 'department_id' => $department_id, 'item_id' => $id, 'parent_id' => $parent_employee,'depth' => $dpdepth);
                           
                            if($dperow){
                                $this->db->where("id", $dperow->id);
                                $this->db->update("department_employee_short",$dpcdata);
                            }else{
                                $this->db->insert("department_employee_short",$dpcdata);
                            }
                        }

                    $this->session->set_flashdata("success", "Empployee Update Successfully");
    
                    redirect("employee");
    
                } else {
    
                    $this->session->set_flashdata("fail", "Empployee Not  Update Successfully");
    
                    //redirect("employee/edit");
    
                }
            }

        }

        $data["edit_employee"] = $this->employee_model->edit($id);

        $this->load->view('admin/employee/edit_employee', $data);

        $this->load->view("admin/include/footer");

    }



    /*

     * Change Status

     */



    public function changestatus($status, $id) {

        $data = array('status' => $status);

        $result = $this->employee_model->changestatus($data, $id);

        if ($result) {

            $this->session->set_flashdata("success", "Empployee Status Update Successfully");

            redirect("employee");

        } else {

            $this->session->set_flashdata("fail", "Empployee Status Not  Update Successfully");

            redirect("employee");

        }

    }



    /*

     * Delete Employee

     */



    public function delete($id) {

        $data = array('is_delete' => 1);

        $result = $this->employee_model->delete($id);

        if ($result) {

            $this->session->set_flashdata("success", "Empployee Delete Successfully");

            redirect("employee");

        } else {

            $this->session->set_flashdata("fail", "Empployee Not  Delete Successfully");

            redirect("employee");

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

    

      /* ****/

    public function create_orgchart() {
        $role = $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($access_level!=2)
        {
             redirect(base_url());
        }
        if($role==2 && $access_level==2){
          $companyid = $this->session->userdata("id");
        }elseif ($role==3 && $access_level==2) {
          $companyid = $this->session->userdata("company");
        }else{
           $companyid = $this->session->userdata("id");
        } 
        
        $usersq = $this->db->query("SELECT id,user_name FROM user_master WHERE CEO = 1 AND company = '".$companyid."'");
        if($usersq->num_rows() == 0){ redirect(base_url('employee')); }

        $data["page_title"] = "ORG Chart | Create ORG Chart";
        //$this->load->view("admin/include/header",$data);
        $this->load->view('admin/employee/create_orgchart', $data);
        //$this->load->view('admin/include/footer');

    }

    

    public function save_sorting(){

        $employees = $this->input->post('data');
        $role = $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company = $this->session->userdata('company');
        }else{
          $company = $this->session->userdata('id');
        } 

        $role = 3;

        $this->db->where('company_id', $company);

        $this->db->delete('employee_short');



        $i=0;

        foreach ($employees as $user) {

            if($i != 0){

                $data = array('company_id' => $company, 'item_id' => $user['item_id'], 'parent_id' => $user['parent_id'], 'depth' => $user['depth']);

                $result = $this->db->insert('employee_short', $data);

            }

            $i++;

        }

    }
    
    public function save_ceo(){
        $employee = $this->input->post('id');
        $role = $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company = $this->session->userdata('company');
        }else{
          $company = $this->session->userdata('id');
        } 

        $query = $this->db->query("SELECT * FROM user_master WHERE company = ".$company." AND ceo = 1");
        $userinfo = $query->row();

        $this->db->where('company', $company);
        $this->db->update('user_master', array('ceo' => 0));

        $this->db->insert('employee_short', array('company_id' => $company, 'item_id' => $userinfo->id, 'parent_id' => 0, 'depth' => 1));

        $query = $this->db->query("SELECT * FROM employee_short WHERE company_id = ".$company." AND parent_id = ".$employee);
        if($query->num_rows()){
            foreach ($query->result() as $user) {
                $this->db->where('item_id', $user->item_id);
                $this->db->update('employee_short', array('depth' => 1, 'parent_id' => 0));
            }
        }

        $this->db->where("item_id",$employee);
        $sql = $this->db->delete("employee_short");

        $this->db->where('id', $employee);
        $this->db->update('user_master', array('ceo' => 1));
    }

    public function save_orgchart(){
        $userid = $this->input->post('userid');
        $parentid = $this->input->post('parentid');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company = $this->session->userdata('company');
        }else{
          $company = $this->session->userdata('id');
        } 

        $query = $this->db->query("SELECT * FROM user_master WHERE id = ".$parentid);
        $userinfo = $query->row();

        $query = $this->db->query("SELECT * FROM employee_short WHERE item_id = ".$parentid);
        $parent = $query->row();

        $query = $this->db->query("SELECT * FROM employee_short WHERE item_id = ".$userid);
        $current = $query->row();

        $data = array('company_id' => $company, 'item_id' => $userid, 'parent_id' => ($userinfo->ceo)?0:$parentid, 'depth' => ($parent)?($parent->depth + 1):1);
        if($current){
            $this->db->where('item_id', $userid);
            $this->db->update('employee_short', $data);
        }else{
            $result = $this->db->insert('employee_short', $data);
        }

        return $data;
    }

    public function get_employee_by_department(){
        $department_id = $this->input->post('id');
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company = $this->session->userdata('company');
        }else{
          $company = $this->session->userdata('id');
        } 

        echo '<option value="0">Select Line manager</option>';
        $query = $this->db->query("SELECT * FROM user_master WHERE status = 1 AND is_delete = 0 AND department_id = ".$department_id." or (ceo=1 and company=".$company.") ORDER BY ceo desc,first_name asc, last_name asc");
         if($query->num_rows()){
            foreach ($query->result() as $value) {
                if($value->ceo==1){
                echo '<option value="'.$value->id.'">'.'CEO: '.$value->first_name.' '.$value->last_name.'</option>';
                }else{
                    echo '<option value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>';
                }
                
            }
        }
    }

    public function download_pdf(){


        $filename = $user_name.'.pdf';  
        $dompdf = new Dompdf();   
        $dompdf->loadHtml($html);
        $dompdf->set_option('isRemoteEnabled', TRUE);
      
        //$dompdf->setPaper('A4', 'landscape');
        //$dompdf->setPaper('A4', 'landscape');
        //$dompdf->set_option('isRemoteEnabled', TRUE);

        //$options->set_option('isHtml5ParserEnabled', true);

        $dompdf->set_option('enable_css_float', true);
        $dompdf->render();
        $dompdf->stream($filename,array("Attachment"=>0));
    }
}

