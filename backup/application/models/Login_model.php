<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function validate_login($email,$password){
        $sql    = "Select id,role,email,password,company,access_level from user_master where email='$email'  and password='$password' and status=1 and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();        
        if(!empty($result)){
            $data =  array('id' =>$result['id'] ,'role'=>$result['role'],"company"=>$result["company"],"access_level"=>$result["access_level"]);
            $this->session->set_userdata($data);
            return true;
        }else{
            return false;
        } 
    }

     /*
     *  Insert Company
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
     * Get Total Record in any table
    */
    public function get_totalrecord($table,$where_colunm,$where_value){
        $sql = "select count(id) as totalrecord from ".$table." where status = 1 and is_delete =0 and ".$where_colunm." = ".$where_value;
        $ex  = $this->db->query($sql);
        $result = $ex->row_array();
        return isset($result["totalrecord"]) ? $result["totalrecord"] : 0;
    }

    /*
     * User Profile
    */
    public function user_profile($id){
        $sql    = "Select id,role,email,password,company,user_image,first_name,last_name,email,phone,designation,about,skill,city from user_master where id='$id' and status=1 and is_delete=0";
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();  
        return $result;
     }

     /*
      * Upadate User Profile
     */
     public function update_userprofile($data,$id){
        $this->db->where("id",$id);
        $sql = $this->db->update("user_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }
     }
}
