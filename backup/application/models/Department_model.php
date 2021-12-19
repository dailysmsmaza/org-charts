<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {
    /*
     * Get department 
     */

    public function get_department_list($per_page,$page_num) {
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
          $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }elseif($role==3 && $access_level==2) {
          $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }elseif($role==3 && $access_level==1) {
          $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }else{
          $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }
        //$company_id = $this->session->userdata('company');
        //echo $_GET['department_id'];
       //print_r($_SESSION);
       
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id");
        $this->db->from("department_master");
        $where = "parent_id = 0";
        $this->db->where($where);
        $this->db->where("company_id", $company_id);
     
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("department_id","DESC");
        //echo $this->db->last_query();
        $ex  = $this->db->get();                
        $result = $ex->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_totalnumber_of_rows(){
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
           $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }elseif($role==3 && $access_level==2) {
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }elseif($role==3 && $access_level==1) {
          $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }else{
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }
        // $access_level=1;
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id");
        $this->db->from("department_master");
        $where = "parent_id = 0";
        $this->db->where($where);
        $this->db->where("company_id", $company_id);
        // $this->db->where("access_level", $access_level);
        //echo $this->db->last_query();
        $ex  = $this->db->get(); 
        return $ex->num_rows();
    }

    /*
        get Sub team
    */
    function get_totalnumber_of_team($department_id){
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
           $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }elseif($role==3 && $access_level==2) {
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }elseif($role==3 && $access_level==1) {
           $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }else{
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }
        // $access_level=1;
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id,parent_id");
        $this->db->from("department_master");
        $this->db->where("parent_id", $department_id);
        $this->db->where("company_id", $company_id);
        // $this->db->where("access_level", $access_level);
       // echo $this->db->last_query();
        $ex  = $this->db->get(); 
        return $ex->num_rows();
    }

     /*
        get Sub team
    */
    function get_totalnumber_of_team_inadmin($companyid,$department_id){
        $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id,parent_id");
        $this->db->from("department_master");
        $this->db->where("parent_id", $department_id);
        $this->db->where("company_id", $companyid);
        //echo $this->db->last_query();
        $ex  = $this->db->get(); 
        return $ex->num_rows();
    }

        function get_team_list_inadmin($per_page,$page_num,$companyid,$department_id) {
        $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
       // echo $company_id;exit;
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id,parent_id");
        $this->db->from("department_master");
        $this->db->where("parent_id", $department_id);
        $this->db->where("company_id", $companyid);
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("department_id","DESC");
        //echo $this->db->last_query();
        $ex  = $this->db->get();      

        $result = $ex->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    function get_team_list($per_page,$page_num,$department_id) {
        $role =  $this->session->userdata('role');
        $access_level=$this->session->userdata('access_level');
        if($role==2 && $access_level==2){
           $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }elseif($role==3 && $access_level==2) {
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }elseif($role==3 && $access_level==1) {
            $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('company');
        }else{
        $company_id = (isset($_GET['department_id']))?$_GET['department_id']:$this->session->userdata('id');
        }
       // echo $company_id;exit;
        $this->db->select("department_master.id as department_id,name,description,department_master.status, slug,company_id,parent_id");
        $this->db->from("department_master");
        $this->db->where("parent_id", $department_id);
        $this->db->where("company_id", $company_id);
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("department_id","DESC");
        //echo $this->db->last_query();
        $ex  = $this->db->get();      

        $result = $ex->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }
    /*
     * Get Company 
     */

    public function get_company_list() {
        $sql = "Select id,first_name,last_name,status from user_master where role=2 and status=1";
        $ex = $this->db->query($sql);
        $result = $ex->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /*
     * Get Company  Employee
     */

    public function get_company_employee($company) {
        $sql = "Select id,first_name,last_name,status from user_master where company='$company' and role=3 and status=1 and is_delete=0";
        $ex = $this->db->query($sql);
        $result = $ex->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /*
     * Add department
     */

    public function insert($data) {
        $result = $this->db->insert("department_master", $data);
        //echo $result;
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Edit department
     */

    public function edit($id) {
        $sql = "Select id,name,description from department_master where id=" . $id . "";
        $ex = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }

       /*
     * Edit subteam
     */

    function edit_subteam($companyid,$id) {
        $sql = "Select id,name,description,parent_id from department_master where id=" . $id . " and parent_id=".$companyid;
        $ex = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }
       /*
     * Edit subteam admin
     */

    function edit_subteaminadmin($companyid,$departmentid,$id) {
        $sql = "Select id,name,description,parent_id from department_master where id=" . $id . " and parent_id=".$departmentid." and company_id=".$companyid;
        $ex = $this->db->query($sql);
        //echo $this->db->last_query();
        $result = $ex->row_array();
        return $result;
    }


    /*
     * Update department
     */

    public function update($data, $id) {
        $this->db->where("id", $id);
        $sql = $this->db->update("department_master", $data);
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Change Status
     */

    public function changestatus($data, $id) {
        $this->db->where("id", $id);
        $sql = $this->db->update("department_master", $data);
        
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Delete 
     */

    public function delete($id) {
        $this->db->where("id", $id);
        $sql = $this->db->delete("department_master");
        if ($sql) {
            $this->db->where("parent_id", $id);
            $sql = $this->db->delete("department_master");
            return true;

        } else {
            return false;
        }
    }

}
