<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->library('pagination');
        $this->load->model("company_model");
        $this->load->model("employee_model");
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");     
        $this->load->model("department_model");
        
        if ($this->session->userdata('id') =="" && $this->session->userdata("role") == 1) {
            redirect("login");
        }        
    }

    /**
     * Company List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | Company";
        $data["heading_title"] = "Company List";
        $page_num = "";
        $this->load->view("admin/include/header",$data);
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        if ($search != "") {
            $page_num = isset($_GET["per_page"]) ? $_GET["per_page"] : "";
            $config['base_url'] = base_url()."company/index?search=".$search;
            $condition = " where first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%' and  role = 2 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            $config['page_query_string'] = TRUE;
            $config['enable_query_strings'] = TRUE;

            $data["total_company"] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query(); 
        }else{           
            $page_num = $this->uri->segment(3);
            $config['base_url'] = base_url()."company/index";
            $condition = " where role = 2 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query();
            $data["total_company"] = get_totalnumber_of_rows("user_master",$condition);;
        }
        
       
        $config['per_page'] = 2;
        $config['use_page_numbers'] = TRUE;
        
        $data["company_list"] = $this->company_model->get_company_list($search,$config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/company/company_list', $data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Add Company
     */

    public function add_company() {
        $data["page_title"] = "ORG Chart | Add Company";
        $data["heading_title"] = "Add Company";        
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
        if ($this->form_validation->run()) {
            if (!empty($_FILES["user_image"]["name"])) {
             $filename = underscore(date("dmY_his") . '_' . $_FILES["user_image"]["name"]);
             $res = $this->do_upload('user_image', $filename, 'assets/userimage/', 'jpg|jpeg|png');
            } else {
                $filename = '';
            }
            $role = 2;
            $access_level=2;
            //$company = $this->input->post("company");
            $first_name = $this->input->post("first_name");
            $last_name = $this->input->post("last_name");
            $user_name = $this->input->post("user_name");
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $phone = $this->input->post("phone");
            //$designation = $this->input->post("designation");
            $about = $this->input->post("about");
            //$skill = $this->input->post("skill");
            $city = $this->input->post("city");
            $error = 0;

            $lowercase = preg_match('#[a-zA-Z]#', $password);
            $number    = preg_match('#[0-9]+#', $password);
            $specialChars = preg_match('#\W+#', $password);

            if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                //redirect(base_url("user/edit/".$id));
                $error = 1;
            }
            $password = md5($this->input->post("password"));

            $exist_username = checkcolunm_exist("user_master", "user_name", $this->input->post("user_name"));
            if ($exist_username) {
                $this->session->set_flashdata("fail", "User Name Already Exist");
                //redirect("login/companyregister");
                $error = 1;
            }
            
            $exist_email = checkcolunm_exist("user_master", "email", $email);            
            if ($exist_email) {
                $this->session->set_flashdata("fail", "Email Already Exist");
                //redirect(base_url("company/add_company"));
                $error = 1;
            }

            if($error == 0){
                $data = array('role'=>$role,'access_level'=>$access_level,"user_image"=>$filename,'first_name' => $first_name, 'user_name' => $user_name, 'last_name' => $last_name,  'email' => $email, 'password' => $password, 'phone' => $phone, 'about' => $about,  'city' => $city);
                $result = $this->company_model->insert($data);
                if ($result) {
                    $this->session->set_flashdata("success", "Company Add Successfully");
                   redirect(base_url("company"));
                } else {
                    $this->session->set_flashdata("fail", "Company Not Add Successfully");
                    //redirect(base_url("company/add_company"));
                }
            }  
        }     
        $this->load->view('admin/company/add_company', $data);
        $this->load->view('admin/include/footer');  
    }

    /*
     * Edit Company
     */

    public function edit($id) {
        $data["page_title"] = "ORG Chart | Edit Company";
        $data["heading_title"] = "Edit Company";
                
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules("email", "Email", "required|valid_email");
        //$this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules("phone", "Phone", "required");
       // $this->form_validation->set_rules("designation", "Designation", "required");
       // $this->form_validation->set_rules("about", "About", "required");
       // $this->form_validation->set_rules("skill", "Skill", "required");
        $this->form_validation->set_rules("city", "City", "required");
        if ($this->form_validation->run() == FALSE) {
           
            
        } else {
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
            $error = 0;

            $password = $this->input->post("password");
            if($_POST["password"]){
                
                $lowercase = preg_match('#[a-zA-Z]#', $password);
                $number    = preg_match('#[0-9]+#', $password);
                $specialChars = preg_match('#\W+#', $password);

                if(!$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                    $this->session->set_flashdata("fail","Password should be at least 6 characters in length and should include at least one letter, one number, and one special character.");
                    //redirect(base_url("user/edit/".$id));
                    $error = 1;
                }
            }

            /* Check Email Exist */
            $query = $this->db->query("Select id,email from user_master");
            $res = $query->result_array();
            $no = $query->num_rows();
            if ($res) {
                foreach ($res as $key => $value) {
                    if ($value["id"] != $id) {
                        if ($email == $value['email']) {
                            $this->session->set_flashdata("fail", "Email Already Exist");
                            //redirect("company/edit/" . $id);
                            $error = 1;
                        }
                    }
                }
            }
           
            if($error == 0){
                $data = array("user_image"=>$filename,'first_name' => $first_name, 'last_name' => $last_name,  'email' => $email, 'phone' => $phone,  'about' => $about,  'city' => $city);
                if($password){ $data['password'] = md5($password); }
                $result = $this->company_model->update($data,$id);
                if ($result) {
                    $this->session->set_flashdata("success", "Company Update Successfully");
                    redirect("company");
                } else {
                    $this->session->set_flashdata("fail", "Company Not  Update Successfully");
                    //redirect("company/edit");
                }
            }
        }
        $this->load->view('admin/include/header',$data);
        $data["edit_company"] =$this->company_model->edit($id);
        $this->load->view('admin/company/edit_company', $data);
        $this->load->view('admin/include/footer');
    }

    /*
     * Change Status
     */

    public function changestatus($status, $id) {
        $data = array('status' => $status);
        $result = $this->company_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Company Status Update Successfully");
            redirect("company");
        } else {
            $this->session->set_flashdata("fail", "Company Status Not  Update Successfully");
            redirect("company");
        }
    }
   

    /*
     * Delete Company
     */

    public function delete($id) {
        $data = array('is_delete' => 1);
        $result = $this->company_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "Company Delete Successfully");
            redirect("company");
        } else {
            $this->session->set_flashdata("fail", "Company Not  Delete Successfully");
            redirect("company");
        }
    }
    /******************************************************************************************************************************
     *                                                    Company Employee Functions                                               *
     * **************************************************************************************************************************** */

    /*
     * View Company Employee Function
     */
    
    public function view_employee(){

        $companyid = $this->uri->segment(3);
        $company   =  get_userinfo($companyid,"first_name","last_name");
        $data["page_title"] = "ORG Chart | View Company Employee";
        $data["heading_title"] = $company["first_name"]." ".$company["last_name"]." Employee List";
        $this->load->view("admin/include/header",$data);
        $data["company_id"] = $companyid;
        $page_num = "";
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $department=isset($_GET["department"]) ? $_GET["department"] : "";
     
        $condition = " where company='$companyid' and role=3 and is_delete=0";
        if($department !=""){
            $condition.= " and (department_id = $department)";
        }
        if($search !=""){
            $condition.= " and (first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%')";
        }   
        $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = true;   
        $data["total_employee"] = get_totalnumber_of_rows("user_master",$condition);
          $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
       
        $data["employee_list"] = $this->company_model->get_compnay_employee_list($department,$search,$companyid, $config["per_page"], $page_num);
        $this->pagination->initialize($config);   
        $this->load->view("admin/companyemployee/employee_list",$data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Add Empployee
     */
    public function add_companyemployee() {
        
        $data["page_title"] = "ORG Chart | Add Employee";
        $data["heading_title"] = "Add Employee";
        $this->load->view("admin/include/header",$data);

        //$this->form_validation->set_rules('company', 'Company', 'required');
        if (empty($_FILES["user_image"]["name"])) {
            $this->form_validation->set_rules('user_image', 'User Image', 'required');
        }
        $this->form_validation->set_rules("access_level", "Access", "required");
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        //$this->form_validation->set_rules("email", "Email", "required|valid_email");
        $this->form_validation->set_rules("phone", "Phone", "");
        $this->form_validation->set_rules("designation", "Designation", "required");
        //$this->form_validation->set_rules("about", "About", "required");
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

            $role = 3;
            $company = $this->input->post("company");

            $first_name = $this->input->post("first_name");
            $access_level = $this->input->post("access_level");
            $last_name = $this->input->post("last_name");
            $email = $this->input->post("email");
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
            $exist_email = checkcolunm_exist("user_master", "email", $email);
           
            if ($exist_email) {
                $this->session->set_flashdata("fail", "Email Already Exist");
                //redirect("company/add_companyemployee/".$company);
                $error = 1;
            }

            if($error == 0){
                $data = array('role' => $role, 'company' => $company, "user_image" => $filename, 'access_level' => $access_level,'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'designation' => $designation, 'about' => $about, 'skill' => $skill, 'city' => $city, 'department_id' => $department_id, 'start_date' => $start_date);
                $result = $this->company_model->insertcompanyemployee($data);
                if ($result) {
                    $insertid = $this->db->insert_id();
                    if($insertid){
                        if($parent_employee){
                            $query = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$parent_employee);
                            $row = $query->row();
                            $cdata = array('company_id' => $company, 'item_id' => $insertid, 'parent_id' => $parent_employee,'depth' => ($row)?($row->depth + 1):1);
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
                    redirect("company/view_employee/".$company);
                } else {
                    $this->session->set_flashdata("fail", "Empployee Not  Add Successfully");
                    //redirect("company/add_companyemployee/".$company);
                }
            }
        }
        $this->load->view('admin/companyemployee/add_employee', $data);
        $this->load->view('admin/include/footer');
    }


    /*
     * Edit Empployee
     */
    public function edit_companyemployee($id) {
        $data["page_title"] = "ORG Chart | Edit Employee";
        $data["heading_title"] = " Edit Employee";
        $this->load->view("admin/include/header", $data);        
        if($id!=''){
            $companyid = get_userinfo($id, 'user_name', 'company');
        }
       // echo $companyid['company'];exit;
        $this->form_validation->set_rules('access_level', 'Access', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
//$this->form_validation->set_rules("email", "Email", "required|valid_email");   
        $this->form_validation->set_rules("phone", "Phone", "");
        $this->form_validation->set_rules("designation", "Designation", "required");
//$this->form_validation->set_rules("about", "About", "required");
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

            $company = $this->input->post("company");

            $access_level = $this->input->post("access_level");

            $first_name = $this->input->post("first_name");
             //echo $first_name.$company;exit;

            $last_name = $this->input->post("last_name");

            $email = $this->input->post("email");

            $phone = $this->input->post("phone");

            $designation = $this->input->post("designation");

            $about = $this->input->post("about");

            $skill = $this->input->post("skill");

            $city = $this->input->post("city");
            $parent_employee = $this->input->post("parent_employee"); 
            $department_id = $this->input->post("department_id");
            $start_date = $this->input->post("start_date");
            $start_date = ($start_date)?date('Y-m-d', strtotime($start_date)):'';

            /* Check Email Exist */

            $query = $this->db->query("Select id,email from user_master");

            $res = $query->result_array();

            $no = $query->num_rows();

            if ($res) {

                foreach ($res as $key => $value) {

                    if ($value["id"] != $id) {

                        if ($email == $value['email']) {

                            $this->session->set_flashdata("fail", "Email Already Exist");

                            redirect("company/edit_companyemployee/".$company);

                        }

                    }

                }

            }

            $data = array( "user_image" => $filename,'access_level' => $access_level, 'first_name' => $first_name, 'last_name' => $last_name,'email' => $email, 'phone' => $phone, 'designation' => $designation, 'about' => $about, 'skill' => $skill, 'city' => $city, 'department_id' => $department_id, 'start_date' => $start_date);
            $result = $this->employee_model->update($data, $id);
            if ($result) {

                //if($parent_employee){
                    // echo $parent_employee;
                    // exit;
                    if($parent_employee){
                        $query = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$parent_employee);
                        $row = $query->row();

                        $equery = $this->db->query('SELECT * FROM employee_short WHERE item_id = '.$id);
                        $erow = $equery->row();                        

                        $edepth = ($erow)?$erow->depth:1;
                        $depth = ($row)?($row->depth + 1):$edepth;
                        $cdata = array('company_id' => $company, 'item_id' => $id, 'parent_id' => $parent_employee,'depth' => $depth);
                   
                        if($erow){
                            $this->db->where("id", $erow->id);
                            $this->db->update("employee_short",$cdata);
                        }else{
                            $this->db->insert("employee_short",$cdata);
                        } 
                    }

                    //Department
                    if($department_id){
                        $dpquery = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$parent_employee);
                        $dprow = $dpquery->row();

                        $dpequery = $this->db->query('SELECT * FROM department_employee_short WHERE item_id = '.$id);
                        $dperow = $dpequery->row();                        

                        $dpedepth = ($dperow)?$dperow->depth:1;
                        $dpdepth = ($dprow)?($dprow->depth + 1):$dpedepth;
                        $dpcdata = array('company_id' => $company, 'department_id' => $department_id, 'item_id' => $id, 'parent_id' => $parent_employee,'depth' => $dpdepth);
                       
                        if($dperow){
                            $this->db->where("id", $dperow->id);
                            $this->db->update("department_employee_short",$dpcdata);
                        }else{
                            $this->db->insert("department_employee_short",$dpcdata);
                        }
                    }
               // }
                    
                $this->session->set_flashdata("success", "Empployee Update Successfully");
                redirect("company/view_employee/".$companyid['company']);
            } else {
                $this->session->set_flashdata("fail", "Empployee Not  Update Successfully");
                redirect("company/edit_companyemployee/".$company);
            }
        }
        $data["edit_employee"] = $this->employee_model->edit($id);
        $this->load->view('admin/companyemployee/edit_employee', $data);
        $this->load->view("admin/include/footer");
    }



    /*
     * Change Status
     */
    public function changestatus_companyemployee($status, $id) {
        $companyid= $this->uri->segment(5);
        $data = array('status' => $status);
        $result = $this->company_model->changestatus_companyemployee($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Empployee Status Update Successfully");
            redirect("company/view_employee/".$companyid);
        } else {
            $this->session->set_flashdata("fail", "Empployee Status Not  Update Successfully");
            redirect("company/view_employee/".$companyid);
        }
    }



    /*
     * Delete Employee
     */
    public function delete_companyemployee($id) {
        $companyid= $this->uri->segment(4);
        $data = array('is_delete' => 1);
        $result = $this->company_model->delete_companyemployee($id);
        if ($result) {
            $this->session->set_flashdata("success", "Empployee Delete Successfully");
            redirect("company/view_employee/".$companyid);
        } else {
            $this->session->set_flashdata("fail", "Empployee Not  Delete Successfully");
            redirect("company/view_employee/".$companyid);
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

    public function department($id){
        $companyid = $this->uri->segment(3);
        $companyname = '';
        if($companyid){
            $company = get_userinfo($companyid, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }
        $data["page_title"] = "ORG Chart | Team";
        $data["heading_title"] = $companyname." Team";
        $data["companyname"] = $companyname;
        $_GET['department_id'] = $id;
        $data["total_department"] = $this->department_model->get_totalnumber_of_rows();
        $page_num = $this->uri->segment(4);
        $config['base_url'] = base_url()."department/index";
        $config['total_rows'] = $this->department_model->get_totalnumber_of_rows();       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["department"] = $this->department_model->get_department_list($config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view("admin/include/header", $data);
        $this->load->view('admin/department/department_list', $data);
        $this->load->view("admin/include/footer");
    }

    public function add_department($company_id) {
        $companyname = '';
        if($company_id){
            $company = get_userinfo($company_id, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }
        $user_id=$this->session->userdata("id");

        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');
        $data['edit_department'] = '';
        if ($this->form_validation->run() == FALSE) {
            $data["companyname"] = $companyname;
            $data["page_title"] = "ORG Chart | Add Team";
            $data["heading_title"] = "Add Team";
            $this->load->view("admin/include/header", $data);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view('admin/department/add_edit_department', $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'company_id' => $company_id,'created_date' => current_datetime(),'dept_createdby' =>$user_id);
            $result = $this->department_model->insert($data);
            if ($result) {
                $dpid = $this->db->insert_id();
                $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' and company_id='".$company_id."' and id!='".$dpid."'");
                if($dquery->num_rows()){
                    $slug = $slug.'-'.$dpid;
                }
                 if($employee_id!=''){
                 foreach($employee_id as $empkey=>$empvalue){

                        if($empvalue!=''){
                            $dataemp=$this->employee_model->update(array('department_id'=>$dpid),$empvalue);
                            //print_r($dataemp);exit;    
                        }
                        
                    }
                }
                $result = $this->department_model->update(array('slug' => $slug), $dpid);

                $this->session->set_flashdata("success", "Team Add Successfully");
                redirect("company/department/".$company_id);
            } else {
                $this->session->set_flashdata("fail", "Team Not  Add Successfully");
                redirect("company/department/".$company_id."/add");
            }
        }
    }

    /*
     * Edit Company
     */

    public function department_edit($companyid, $id) {
        $user_id=$this->session->userdata("id");
        $companyname = '';
        if($companyid){
            $company = get_userinfo($companyid, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }

        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');

        if ($this->form_validation->run() == FALSE) {
            $data["companyname"] = $companyname;
            $data["page_title"] = " ORG Chart | Edit Team";
            $data["heading_title"] = "Edit Team";
            $this->load->view("admin/include/header",$data);
            $data["edit_department"] = $this->department_model->edit($id);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view("admin/department/add_edit_department", $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' AND id != '".$id."' and company_id='".$companyid."' " );
            if($dquery->num_rows()){
                $slug = $slug.'-'.$id;
            }

            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'updated_date' => current_datetime(),'dept_updatedby' =>$user_id);

             $deptdata=$this->db->query("UPDATE `user_master` SET `department_id` = '0' WHERE `user_master`.`department_id` = ".$id);

             if($employee_id!=''){
                foreach($employee_id as $empkey=>$empvalue){
                            if($empvalue!=''){
                                $dataemp=$this->employee_model->update(array('department_id'=>$id,'company'=>$companyid),$empvalue);
                                
                           }
                        }
                     }

            $result = $this->department_model->update($data, $id);
            if ($result) {
                $this->session->set_flashdata("success", "Company Update Successfully");
                redirect("company/department/".$companyid);
            } else {
                $this->session->set_flashdata("fail", "Company Not  Update Successfully");
                redirect("company/department/".$companyid."edit/" . $id);
            }
        }
    }


      /*
     * Sub Team Listing
     */

    public function subteam($companyid, $id) {
      
        $companyid = $this->uri->segment(3);
         // echo $companyid."> ";
         // echo $id;exit;

        $companyname = '';
        if($companyid){
            $company = get_userinfo($companyid, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }
        $data["page_title"] = "ORG Chart | Sub Team";
        $data["heading_title"] = $companyname." Sub Team";
        $data["companyname"] = $companyname;
       // $_GET['department_id'] = $id;
        $data["total_department"] = $this->department_model->get_totalnumber_of_team_inadmin($companyid,$id);
        $page_num = $this->uri->segment(6);
        //$page_num= $this->uri->uri_to_assoc(6);
        $config['total_rows'] = $this->department_model->get_totalnumber_of_team_inadmin($companyid,$id);       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["department"] = $this->department_model->get_team_list_inadmin($config["per_page"],$page_num,$companyid,$id);
        $this->pagination->initialize($config);
        $this->load->view("admin/include/header", $data);
        $this->load->view('admin/department/subteam_list', $data);
        $this->load->view("admin/include/footer");
    }

    /*
        Add Sub team
    */

     public function add_subteam($company_id,$id) {
        // echo $company_id.">";
        // echo $id;exit;

        $companyname = '';
        if($company_id){
            $company = get_userinfo($company_id, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }
        $user_id=$this->session->userdata("id");
        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Description', '');

        $data['edit_subteam'] = '';
        if ($this->form_validation->run() == FALSE) {
            $data["companyname"] = $companyname;
            $data["page_title"] = "ORG Chart | Add Team";
            $data["heading_title"] = "Add Team";
            $this->load->view("admin/include/header", $data);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view('admin/department/add_edit_subteam', $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $parent_id=$id;
            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'company_id' => $company_id,'created_date' => current_datetime(),'dept_createdby' =>$user_id,'parent_id' => ($parent_id)?$parent_id:4);
            $result = $this->department_model->insert($data);
            if ($result) {
                $dpid = $this->db->insert_id();
                $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' and company_id = '".$company_id."' and id!='".$dpid."' ");
                if($dquery->num_rows()){
                    $slug = $slug.'-'.$dpid;
                }

                if($employee_id!=''){
                 foreach($employee_id as $empkey=>$empvalue){

                        if($empvalue!=''){
                            $dataemp=$this->employee_model->update(array('department_id'=>$dpid),$empvalue);
                            //print_r($dataemp);exit;    
                        }
                        
                    }
                }
                $result = $this->department_model->update(array('slug' => $slug), $dpid);

                $this->session->set_flashdata("success", "Subteam Add Successfully");
                redirect("company/department/".$company_id."/subteam/".$id);
            } else {
                $this->session->set_flashdata("fail", "Subteam Not Add Successfully");
                redirect("company/department/".$company_id."/subteam/".$id."/add_subteam");
            }
        }
    }


    /*
        Edit Sub team
    */
    public function edit_subteaminadmin($companyid,$departmentid,$id) {
       $user_id=$this->session->userdata("id");
        $companyname = '';
        if($companyid){
            $company = get_userinfo($companyid, 'first_name', 'last_name');
            $companyname = ($company)?$company['first_name'].' '.$company['last_name']:'';
        }

        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');

        if ($this->form_validation->run() == FALSE) {
            $data["companyname"] = $companyname;
            $data["page_title"] = " ORG Chart | Edit Team";
            $data["heading_title"] = "Edit Team";
            $this->load->view("admin/include/header",$data);
            $data["edit_subteam"] = $this->department_model->edit_subteaminadmin($companyid,$departmentid,$id);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view("admin/department/add_edit_subteam", $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' AND id != '".$id."' and company_id = '".$company_id."' ");
            if($dquery->num_rows()){
                $slug = $slug.'-'.$id;
            }

            $deptdata=$this->db->query("UPDATE `user_master` SET `department_id` = '0' WHERE `user_master`.`department_id` = ".$id);

             if($employee_id!=''){
                foreach($employee_id as $empkey=>$empvalue){
                            if($empvalue!=''){
                                $dataemp=$this->employee_model->update(array('department_id'=>$id,'company'=>$companyid),$empvalue);
                                
                           }
                        }
                     }
                     
            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'updated_date' => current_datetime(),'dept_updatedby' =>$user_id);
            $result = $this->department_model->update($data, $id);
            if ($result) {
                $this->session->set_flashdata("success", "Subteam Update Successfully");
                redirect("company/department/".$companyid."/subteam/".$departmentid);
            } else {
                $this->session->set_flashdata("fail", "Subteam Not Update Successfully");
                redirect("company/department/".$companyid."/subteam/".$departmentid."/edit_subteam/" . $id);
            }
        }
    }

    public function get_cmpemployee_by_department(){

        $department_id = $this->input->post('id');
         $companyid = $this->input->post('companyid');
        echo '<option value="0">Select Line manager</option>';
        $query = $this->db->query("SELECT * FROM user_master WHERE status = 1 AND is_delete = 0 AND department_id = ".$department_id." OR (ceo=1 and company=".$companyid.") ORDER BY ceo desc,first_name asc, last_name asc");
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

}
