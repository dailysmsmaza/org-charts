<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function get_user_list($search,$per_page,$page_num){
        $where = "";
        if($search !=""){
            $where = "  first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%' ";
        }
        $this->db->select("id,first_name,last_name,email,phone,status,role");
        $this->db->from("user_master");
        
        $this->db->where('role=',1);
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
     *  Insert User
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
     * Edit User
    */
    public function edit($id){
        $sql    = "Select id ,first_name,last_name,email,phone,company,role,user_image,phone,designation,about,skill,city from user_master where id='$id' and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }
    
    /*
    * Update User
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
        $this->db->where("id",$id);
        $sql = $this->db->delete("user_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

}
