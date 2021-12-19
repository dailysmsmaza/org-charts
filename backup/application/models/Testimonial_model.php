<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {
    /*
     * Get Testimonial 
     */

    public function get_testimonial_list($per_page,$page_num) {
        //echo $sql = "Select testimonial_master.id as ,user_id,message,testimonial_master.status,testimonial_master.is_delete,user_master.id,first_name,last_name from testimonial_master,user_master where testimonial_master.user_id = user_master.id and testimonial_master.is_delete=0 LIMIT ".$per_page." ".$page_num;
        $this->db->select("testimonial_master.id as testimonial_id,user_id,message,testimonial_master.status,testimonial_master.is_delete,user_master.id,first_name,last_name");
        $this->db->from("testimonial_master,user_master");
        $where = "testimonial_master.user_id = user_master.id";
        $this->db->where($where);
        $this->db->where('testimonial_master.is_delete ', 0);   

        $offset = ($page_num)?($page_num - 1) * $per_page:0;
        $this->db->limit($per_page,$offset);
        $this->db->order_by("testimonial_id","DESC");
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
        $sql = "Select id,first_name,last_name,status from user_master where role=2 and status=1 and is_delete=0";
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
     * Add Testimonial
     */

    public function insert($data) {
        $result = $this->db->insert("testimonial_master", $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Edit Testimonial
     */

    public function edit($id) {
        $sql = "Select id,user_id,message from testimonial_master where id=" . $id . "";
        $ex = $this->db->query($sql);
        $result = $ex->row_array();
        return $result;
    }

    /*
     * Update Testimonial
     */

    public function update($data, $id) {
        $this->db->where("id", $id);
        $sql = $this->db->update("testimonial_master", $data);
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
        $sql = $this->db->update("testimonial_master", $data);
        
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
        $sql = $this->db->delete("testimonial_master");
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

}
