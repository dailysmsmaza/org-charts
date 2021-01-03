<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

    public $table = 'category_master'; // you MUST mention the table name
    public $primary_key = 'category_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_categories()
    {
        $result = $this->db->get($this->table);
        $city_list = $result->result_array();
        return $city_list;
    }


}

/* End of file Application_model.php */

