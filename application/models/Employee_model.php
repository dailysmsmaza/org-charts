<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {
    
    public function get_employee_list($department="",$search="",$company="",$per_page="",$page_num=""){
        $where = "";       
        $this->db->select("*");
        $this->db->from("user_master");
        if($department !=""){
            $where = " (department_id=$department)";
        }
        // if(isset($_GET['department'])){
        //     if($_GET['department']){
        //         $this->db->where('department_id', $_GET['department']);
        //     }
        // }
        $this->db->where("company",$company);
        $this->db->where('role',3);
        $this->db->where('is_delete ', 0);
        if($department !=""){
            $this->db->where($where);
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
     *  Get Company 
     */
    public  function get_company_list(){
        $sql = "select id,first_name,last_name from user_master where role=2 and status=1 and is_delete=0";
        $ex  = $this->db->query($sql);
        $result = $ex->result_array();
        return $result;
    }
    /*
     *  Insert Employee
     */
    public function insert($data){
        $sql = $this->db->insert("user_master",$data);
        if($sql){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /*
     * Edit Employee
    */
    public function edit($id){
        $sql    = "Select * from user_master where id='$id' and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }
    
    /*
    * Update Employee
    */
    public function update($data,$id){
         //print_r($data);
        // print_r($id);
        // // exit;
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
       // echo $this->db->last_query();
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
        $this->db->where("id",$id);
        $sql = $this->db->delete("user_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

}
