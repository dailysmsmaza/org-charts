<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Givefeedback_model extends CI_Model {
   
    
        public function get_givefeedback_list($srch_givedate="",$search="",$per_page="",$page_num=""){
        $where = "";
        $user_id=$this->session->userdata("id");
        $role =  $this->session->userdata('role');
        if($search !=""){
            $where = " (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or givefd_subject Like '%$search%' or givefd_message Like '%$search%') ";
        }

        if($srch_givedate !=""){
            $srchwhere = " (CAST(givefd_createddate as date) = '".$srch_givedate."')";
        }
        
        $this->db->select("givefd_id,`company_id`, umfrom.first_name as givefd_userfrom,givefd_subject,givefd_message,umto.first_name as givefd_userto,givefd_status,givefd_createddate,givefd_updateddate");
        
        $this->db->from("givefdbck_master as givefd,user_master as umfrom, user_master as umto");
        
        $this->db->where('givefd.givefd_userfrom=umfrom.id and givefd.givefd_userto=umto.id ');

         if($role!=1){
            $this->db->where("givefd_userfrom", $user_id);
         }
       
        if($search !=""){
            $this->db->where($where);
        }

        if($srch_givedate !=""){
            $this->db->where($srchwhere);
        }
       
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("givefd_id","DESC");
        $ex  = $this->db->get();
      // echo $this->db->last_query();
        $result = $ex->result_array();        

        if(!empty($result)){
            return $result;
        }else{
            return false;
        }         
        
    }

    public function get_receviedgivefeedback_list($srch_givedate="",$search="",$per_page="",$page_num=""){
        $where = "";
        $user_id=$this->session->userdata("id");
        $role =  $this->session->userdata('role');
        if($search !=""){
            $where = " (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or givefd_subject Like '%$search%' or givefd_message Like '%$search%') ";
        }
        
        if($srch_givedate !=""){
            $srchwhere = " (CAST(givefd_createddate as date) = '".$srch_givedate."')";
        }

        $this->db->select("givefd_id,`company_id`, umfrom.first_name as givefd_userfrom,givefd_subject,givefd_message,umto.first_name as givefd_userto,givefd_status,givefd_createddate,givefd_updateddate");
        
        $this->db->from("givefdbck_master as givefd,user_master as umfrom, user_master as umto");
        
        $this->db->where('givefd.givefd_userfrom=umfrom.id and givefd.givefd_userto=umto.id ');

         if($role!=1){
            $this->db->where("givefd_userto", $user_id);
         }
       
        if($search !=""){
            $this->db->where($where);
        }

        if($srch_givedate !=""){
            $this->db->where($srchwhere);
        }
       
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("givefd_id","DESC");
        $ex  = $this->db->get();
      
      // echo $this->db->last_query();
        $result = $ex->result_array();        

        if(!empty($result)){
            return $result;
        }else{
            return false;
        }         
        
    }

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

     public function insert($data) {
        $result = $this->db->insert("givefdbck_master", $data);
        //echo $result;
        //echo $this->db->last_query();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

      public function delete($givefd_id){
        
        $this->db->where("givefd_id",$givefd_id);
        $sql = $this->db->delete("givefdbck_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    public function edit($givefd_id){
        $sql    = "Select * from givefdbck_master where givefd_id=".$givefd_id;
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }


      public function update($data,$givefd_id){
        
        $this->db->where("givefd_id",$givefd_id);
        $sql = $this->db->update("givefdbck_master",$data);
       
        if($sql){
            return true;
        }else{
            return false;
        }
    }

}
