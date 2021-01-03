<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategory_model extends MY_Model {

    public $table = 'subcategory_master'; // you MUST mention the table name
    public $primary_key = 'subcategory_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_sub_categories(){
        $category_id = $this->input->get('category_id');
        $this->db->where_in('category_id', $category_id);
        $result = $this->db->get($this->table);
        $sub_category_list = $result->result_array();
        return $sub_category_list;
    }
}

/* End of file Application_model.php */