<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requestfeedback_model extends CI_Model {
   
    
        public function get_requestfeedback_list($srch_reqfddate="",$search="",$per_page="",$page_num=""){
        $where = "";
        $user_id=$this->session->userdata("id");
        $role =  $this->session->userdata('role');
        if($search !=""){
            $where = " (umfrom.first_name like '%$search%' or umto.first_name like '%$search%' or reqfd_subject Like '%$search%' or reqfd_message Like '%$search%' or reqfd_reply Like '%$search%')";
        }
       
       if($srch_reqfddate !=""){
            $srchwhere = " (CAST(reqfd_createddate as date) = '".$srch_reqfddate."')";
        }
        
        $this->db->select(" reqfd_id,company_id, umfrom.first_name as reqfd_userfrom,reqfd_subject,reqfd_message,umto.first_name as reqfd_userto,reqfd_status,reqfd_reply,reqfd_createddate,reqfd_createdby,reqfd_updateddate,reqfd_updatedby");
        
        $this->db->from("`requestfdbck_master` as reqfd,user_master as umfrom, user_master as umto");
        
        $this->db->where('reqfd.reqfd_userfrom=umfrom.id and reqfd.reqfd_userto=umto.id ');
        if($role==2){
            $this->db->where("reqfd_userfrom", $user_id);
        }
        if($role==3){
            $usertowhere = " (`reqfd_userfrom` = ".$user_id." or reqfd_userto = ".$user_id.")";
            $this->db->where($usertowhere);    
        }
 
        if($search !=""){
            $this->db->where($where);
        }

        if($srch_reqfddate !=""){
            $this->db->where($srchwhere);
        }
       
        $offset = ($page_num)?($page_num - 1) * $per_page:0;
      //  print_r($per_page);
        $this->db->limit($per_page,$offset);
        $this->db->order_by("reqfd_id","DESC");
        $ex  = $this->db->get();
        //echo $this->db->last_query();
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
        $result = $this->db->insert("requestfdbck_master", $data);
        //echo $result;
        //echo $this->db->last_query();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

     /*
     * Update request feedback
    */
    public function update($data,$reqfd_id){
        
        $this->db->where("reqfd_id",$reqfd_id);
        $sql = $this->db->update("requestfdbck_master",$data);
       
        if($sql){
            return true;
        }else{
            return false;
        }

    }

    public function edit($reqfd_id){
        $sql    = "Select * from requestfdbck_master where reqfd_id=".$reqfd_id;
        $ex     = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }

    public function delete($reqfd_id){
        
        $this->db->where("reqfd_id",$reqfd_id);
        $sql = $this->db->delete("requestfdbck_master");
        if($sql){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Change Status
    */
    public function changestatus($data,$reqfd_id){
        $this->db->where("reqfd_id",$reqfd_id);
        $sql = $this->db->update("requestfdbck_master",$data);
        if($sql){
            return true;
        }else{
            return false;
        }
    }


}
