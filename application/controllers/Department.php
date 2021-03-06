<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("department_model");
        $this->load->model("employee_model");
        $this->load->library('form_validation');
        $this->load->library('pagination');
        if ($this->session->userdata('id') =="") {
            redirect("login");
        } 
        $access_level = $this->session->userdata("access_level");
        $role=$this->session->userdata("role");
        /*if(($access_level!=2 && $role!=2)||($access_level!=2 && $role!=3))
        {
             redirect("login");
        }*/
        if($access_level!=2 && $access_level!=1){
             redirect("login/dashboard");
        }
    }

    /**
     * department List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | Team";
        $data["heading_title"] = "Team";
        $this->load->view("admin/include/header", $data);
        $condition = "";
        $data["total_department"] = $this->department_model->get_totalnumber_of_rows();
        $page_num = $this->uri->segment(3);
        $config['base_url'] = base_url()."department/index";
        $config['total_rows'] = $this->department_model->get_totalnumber_of_rows();       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["department"] = $this->department_model->get_department_list($config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/department/department_list', $data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Get Company Employee Data
     */

    public function get_company_employee() {
        $company = $this->input->post("company");
        $data = $this->department_model->get_company_employee($company);
        echo json_encode($data);
    }

    /*
     * Add department
     */

    public function add_department() {
        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');
        $role =  $this->session->userdata('role');
        $user_id=$this->session->userdata("id");
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company_id = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company_id = $this->session->userdata('company');
        }else{
           $company_id = $this->session->userdata('id');
        }
        

        $data['edit_department'] = '';
        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = "ORG Chart | Add Team";
            $data["heading_title"] = "Add Team";
            $this->load->view("admin/include/header", $data);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view('admin/department/add_edit_department', $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            //$description = $this->input->post("description");
            $employee_id= $this->input->post("employee_id");
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'company_id' => $company_id,'created_date' => current_datetime(),'dept_createdby' =>$user_id);
            //print_r($data);exit;
            $result = $this->department_model->insert($data);

            if ($result) {
                $dpid = $this->db->insert_id();
                $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' and company_id='".$company_id."' and id!='".$dpid."'");
                if($dquery->num_rows()){
                    $slug = $slug.'-'.$dpid;
                }
                $result = $this->department_model->update(array('slug' => $slug), $dpid);
                 if($employee_id!=''){
                 foreach($employee_id as $empkey=>$empvalue){
                   
                    if($empvalue!=''){
                        $dataemp=$this->employee_model->update(array('department_id'=>$dpid),$empvalue);
                        //print_r($dataemp);exit;  
                     }                 
                }
            }

               // print_r($result);exit;

                $this->session->set_flashdata("success", "Team Add Successfully");
                redirect("department");
            } else {
                $this->session->set_flashdata("fail", "Team Not  Add Successfully");
                redirect("department/add_department");
            }


        }
    }

    /*
     * Edit Company
     */

    public function edit($id) {
        $role =  $this->session->userdata('role');
        $user_id=$this->session->userdata("id");
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
         $company_id = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company_id = $this->session->userdata('company');
        }else{
           $company_id = $this->session->userdata('id'); 
        }
        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');

        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = " ORG Chart | Edit Team";
            $data["heading_title"] = "Edit Team";
            $this->load->view("admin/include/header",$data);
            $data["department_id"] = $id;
            $data["edit_department"] = $this->department_model->edit($id);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view("admin/department/add_edit_department", $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' AND id != '".$id."' and company_id='".$company_id."' ");
            if($dquery->num_rows()){
                $slug = $slug.'-'.$id;
            }

            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'updated_date' => current_datetime(),'dept_updatedby' =>$user_id);

            $deptdata=$this->db->query("UPDATE `user_master` SET `department_id` = '0' WHERE `user_master`.`department_id` = ".$id);
           
               if($employee_id!=''){
                foreach($employee_id as $empkey=>$empvalue){
                           
                            if($empvalue!=''){
                                $dataemp=$this->employee_model->update(array('department_id'=>$id),$empvalue);
                                
                           }
                        }
                     }
           
            $result = $this->department_model->update($data, $id);
            if ($result) {
                $this->session->set_flashdata("success", "Company Update Successfully");
                redirect("department");
            } else {
                $this->session->set_flashdata("fail", "Company Not  Update Successfully");
                redirect("department/edit/" . $id);
            }
        }
    }

    /*
     * Change Status
     */

    public function changestatus($status, $id) {
        $role =  $this->session->userdata('role');
        $redirecturl = "department";
        if($role == 1){
            $chartck = $this->db->query("SELECT * FROM department_master WHERE id = ".$id);
            $ct = $chartck->row();

            $companyid = $ct->company_id;
            $redirecturl = 'company/department/'.$companyid;
        }

        $data = array('status' => $status);
        $result = $this->department_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Team Status Update Successfully");
            
        } else {
            $this->session->set_flashdata("fail", "Team Status Not  Update Successfully");
        }
        redirect($redirecturl);
    }

    /*
     * Change Sub team Status
     */

    public function changestatussubteam($status, $companyid,$id) {
        $role =  $this->session->userdata('role');
        $redirecturl = "department/subteam/".$companyid;
        $data = array('status' => $status);
        $result = $this->department_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Subteam Status Update Successfully");
            
        } else {
            $this->session->set_flashdata("fail", "Subteam Status Not  Update Successfully");
        }
        redirect($redirecturl);
    }

    /*
     * Change Sub team Status
     */

    public function changestatussubteamadmin($status, $companyid, $departmentid,$id) {
        $role =  $this->session->userdata('role');
        $redirecturl = 'company/department/'.$companyid.'/subteam/'.$departmentid;
        $data = array('status' => $status);
        $result = $this->department_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Subteam Status Update Successfully");
            
        } else {
            $this->session->set_flashdata("fail", "Subteam Status Not  Update Successfully");
        }
        redirect($redirecturl);
    }



    /*
     * Delete department
     */

    public function delete($id) {
        $role =  $this->session->userdata('role');
        $redirecturl = "department";
        if($role == 1){
            $chartck = $this->db->query("SELECT * FROM department_master WHERE id = ".$id);
            $ct = $chartck->row();

            $companyid = $ct->company_id;
            $redirecturl = 'company/department/'.$companyid;
        }

        $result = $this->department_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "Team Delete Successfully");
        } else {
            $this->session->set_flashdata("fail", "Team Not  Delete Successfully");
        }
        redirect($redirecturl);
    }

     /*
     * Delete Subteam
     */

    public function deleteteam($companyid,$id) {
        $role =  $this->session->userdata('role');
        $redirecturl = "department/subteam/".$companyid;
        $result = $this->department_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "Subteam Delete Successfully");
        } else {
            $this->session->set_flashdata("fail", "Subteam Not  Delete Successfully");
        }
        redirect($redirecturl);
    }

     /*
     * Delete Subteam in admin
     */

    public function deleteteaminadmin($companyid,$departmentid,$id) {
        $role =  $this->session->userdata('role');
        $redirecturl = 'company/department/'.$companyid.'/subteam/'.$departmentid;
        $result = $this->department_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "Subteam Delete Successfully");
        } else {
            $this->session->set_flashdata("fail", "Subteam Not  Delete Successfully");
        }
        redirect($redirecturl);
    }

    public function create_orgchart($id) {
        $role = $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($access_level!=2 && $access_level!=1)
        {
             redirect(base_url());
        }
        if($role==2 && $access_level==2){
          $companyid = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $companyid = $this->session->userdata('company');
        }elseif($role==3 && $access_level==1) {
          $companyid = $this->session->userdata('company');
        }else{
           $company_id = $this->session->userdata('id');
        } 
       // $companyid = $this->session->userdata("id");

        $usersq = $this->db->query("SELECT id,user_name FROM user_master WHERE company = '".$companyid."' AND department_id = ".$id);
        if($usersq->num_rows() == 0){ redirect(base_url('department')); }

        $data["page_title"] = "ORG Chart | Create ORG Chart";
        $data["department_id"] = $id;
        //$this->load->view("admin/include/header",$data);
        $this->load->view('admin/department/create_orgchart', $data);
        //$this->load->view('admin/include/footer');

    }

    function dsaveorgchart(){
        $userid = $this->input->post('userid');
        $parentid = $this->input->post('parentid');
        $department_id = $this->input->post('department_id');
        $company = $this->session->userdata('id');

        /*$query = $this->db->query("SELECT * FROM user_master WHERE id = ".$parentid);
        $userinfo = $query->row();*/
        $parent = '';
        if($parentid){
            $query = $this->db->query("SELECT * FROM department_employee_short WHERE item_id = ".$parentid);
            $parent = $query->row();
        }

        $query = $this->db->query("SELECT * FROM department_employee_short WHERE item_id = ".$userid);
        $current = $query->row();

        $data = array('company_id' => $company, 'department_id' => $department_id, 'item_id' => $userid, 'parent_id' => ($parentid)?$parentid:0, 'depth' => ($parent)?($parent->depth + 1):1);
        if($current){
            $this->db->where('item_id', $userid);
            $this->db->update('department_employee_short', $data);
        }else{
            $result = $this->db->insert('department_employee_short', $data);
        }
     return ($data);
    }


     /*
     * SubTeam Listing
     */

    public function subteam($id) {
        //echo($id);exit;
        $data["page_title"] = "ORG Chart |Sub Team";
        $data["heading_title"] = "Sub Team";
        $this->load->view("admin/include/header", $data);
        $condition = "";
        $data["total_department"] = $this->department_model->get_totalnumber_of_team($id);
        $page_num = $this->uri->segment(5);
        $config['total_rows'] = $this->department_model->get_totalnumber_of_team($id);       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["department"] = $this->department_model->get_team_list($config["per_page"],$page_num,$id);
        $this->pagination->initialize($config);
        $this->load->view('admin/department/subteam_list', $data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Add subteam
     */

    public function add_subteam($id) {
        //echo($id);exit;
        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');

        $role =  $this->session->userdata('role');
        $user_id=$this->session->userdata("id");
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
         $company_id = $this->session->userdata('id');
        }elseif ($role==3 && $access_level==2) {
          $company_id = $this->session->userdata('company');
        }else{
           $company_id = $this->session->userdata('id');
        }
        //echo $id;exit;
        $data['edit_subteam'] = '';
        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = "ORG Chart | Add Subteam";
            $data["heading_title"] = "Add Subteam";
            $this->load->view("admin/include/header", $data);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view('admin/department/add_edit_subteam', $data);
            $this->load->view("admin/include/footer");
        } else {
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");

            $parent_id=$id;
          
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            
            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'company_id' => $company_id,'created_date' => current_datetime(),'dept_createdby' =>$user_id,'parent_id' => ($parent_id)?$parent_id:4);
            $result = $this->department_model->insert($data);
            if ($result) {
                $dpid = $this->db->insert_id();
                $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' and company_id='".$company_id."' and id!='".$dpid."' ");
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
                    redirect("department/subteam/".$id);
                } else {
                    $this->session->set_flashdata("fail", "Subteam Not  Add Successfully");
                    redirect("department/add_subteam");
                }
        }
    }

    /*
     * Edit subteam
     */

    public function edit_subteam($companyid,$id) {
        $user_id=$this->session->userdata("id");
        $this->form_validation->set_rules('name', 'Name', 'required');       
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('employee_id', 'Employee', '');

        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = " ORG Chart | Edit Subteam";
            $data["heading_title"] = "Edit Subteam";
            $this->load->view("admin/include/header",$data);
            $data["edit_subteam"] = $this->department_model->edit_subteam($companyid,$id);
            $data["company"] = $this->department_model->get_company_list();
            $this->load->view("admin/department/add_edit_subteam", $data);
            $this->load->view("admin/include/footer");
        }else{
            $name = $this->input->post("name");
            $description = $this->input->post("description");
            $employee_id = $this->input->post("employee_id");
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $dquery = $this->db->query("SELECT * FROM department_master WHERE slug = '".$slug."' AND id != '".$id."' and company_id='".$companyid."' ");
            if($dquery->num_rows()){
                $slug = $slug.'-'.$id;
            }

            $data = array('name' => $name, 'slug' => $slug, "description" => $description, 'updated_date' => current_datetime(),'dept_updatedby' =>$user_id);
            $deptdata=$this->db->query("UPDATE `user_master` SET `department_id` = '0' WHERE `user_master`.`department_id` = ".$id);
           
               if($employee_id!=''){
                foreach($employee_id as $empkey=>$empvalue){
                           
                            if($empvalue!=''){
                                $dataemp=$this->employee_model->update(array('department_id'=>$id),$empvalue);
                                
                           }
                        }
                     }
            $result = $this->department_model->update($data, $id);
            if ($result) {
                $this->session->set_flashdata("success", "Subteam Update Successfully");
                redirect("department/subteam/".$companyid);
            } else {
                $this->session->set_flashdata("fail", "Subteam Not Update Successfully");
                redirect("department/subteam/".$companyid."/edit_subteam/" . $id);
            }
        }
    }

}
