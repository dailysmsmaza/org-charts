<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function get_testimonial(){
        $sql = "Select testimonial_master.id as testimonial_id,user_id,message,testimonial_master.status,testimonial_master.is_delete,user_master.id,first_name,last_name,user_image,designation from testimonial_master,user_master where testimonial_master.user_id = user_master.id and testimonial_master.status = 1 AND testimonial_master.is_delete=0 ORDER BY RAND()";
        $ex = $this->db->query($sql);
        $no = $ex->num_rows();
        $result  = $ex->row_array();
        return $result;       
    }
    

}
