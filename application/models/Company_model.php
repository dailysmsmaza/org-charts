<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {
    /*
     * Get Company 
    */
    public function get_company_list($search="",$per_page="",$page_num=""){
        $where = "";
        if($search !=""){
            $where = "  first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%' ";
        }
        $this->db->select("id,first_name,last_name,email,phone,status,role");
        $this->db->from("user_master");
        
        $this->db->where('role=',2);
        if($search !=""){
            $this->db->where($where);
        }
        $this->db->where('is_delete ', 0);

        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("id","DESC");
        $ex  = $this->db->get();
        //echo $this->db->last_query();
        $result = $ex->result_array();        
        if(!empty($result)){
            return $result;
        }else{
            return false;
        }         
        
    }

    /*
     * Add Company
    */
    public function insert($data){
        $result = $this->db->insert("user_master",$data);
        if ($result) {
            return true;
        }else{
            return false;
        }
    }
    /*
     * Edit Company
    */
    public function edit($id){
        $sql    = "Select * from user_master where id='$id' and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }
    /*
     * Update Company
    */
    public function update($data,$id){
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }

    }
    /*
     * Change Status
    */
    public function changestatus($data,$id){
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Delete 
    */
    public function delete($id){
        $this->db->where("company_id",$id);
        $sql = $this->db->delete("employee_short");

        $this->db->where("company",$id);
        $this->db->where("role",3);
        $sql = $this->db->delete("user_master");

        $this->db->where("id",$id);
        $sql = $this->db->delete("user_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Get Company Employee 
    */
    public function get_compnay_employee_list($department="",$search="",$companyid, $per_page="",$page_num=""){
        $where = "";       
        if($search !=""){
            $srchwhere = " (first_name Like '%$search%' or last_name Like '%$search%' or email Like '%$search%' or phone Like '%$search%')";
        }
       
       if($department !=""){
            $srchdeptwhere = " (department_id=$department)";
        }
        $this->db->select("id,first_name,last_name,email,phone,status,role,company,department_id,start_date,access_level");
        $this->db->from("user_master");
        $where = "  company Like '%$companyid%'";
        $this->db->where($where);        
        $this->db->where('role',3);
        $this->db->where('is_delete ', 0);        
         if($search !=""){
            $this->db->where($srchwhere);
        }

        if($department !=""){
            $this->db->where($srchdeptwhere);
        }
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        
        $ex  = $this->db->get();    
        //echo $this->db->last_query();
        $result = $ex->result_array();        
        if(!empty($result)){
            return $result;
        }else{
            return false;
        } 
    }

    /*
     *  Insert Company Employee
     */
    public function insertcompanyemployee($data){
        $sql = $this->db->insert("user_master",$data);
        if($sql){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /*
     * Edit Company Employee
    */
    public function editcompanyemployee($id){
        $sql    = "Select id ,first_name,last_name,email,phone,company,role,user_image,phone,designation,about,skill,citydepartment_id,start_date from user_master where id='$id' and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }
    
    /*
    * Update Company Employee
    */
    public function updatecompanyemployee($data,$id){
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Change Status Company Employee
    */
    public function changestatus_companyemployee($data,$id){
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Delete  Company Employee
    */
    public function delete_companyemployee($id){
        $this->db->where("id",$id);
        $sql = $this->db->delete("user_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

}
