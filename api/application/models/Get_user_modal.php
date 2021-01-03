<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_user_modal extends MY_Model {

    public $table = 'users'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_users()
    {
        // $this->input->get('category');
        $category = $this->input->get('category');
        $subCategory = $this->input->get('sub_category');
        $zipCode = $this->input->get('zip_code');
        $except = $this->input->get('except');

        $this->db->where_in('category', $category);
        $this->db->where_in('sub_category', $subCategory);
        $this->db->where_in('zip_code', $zipCode);
        $this->db->where_not_in('phone_number', $except);

        $result = $this->db->get($this->table);
        $city_list = $result->result_array();
        return $city_list;
    }
}


/* End of file Application_model.php */

