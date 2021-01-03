<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_particular_user_modal extends MY_Model {

    public $table = 'users'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_user()
    {
        // $this->input->get('category');
        $phone_number = $this->input->get('phone_number');

        $this->db->like('phone_number', $phone_number);

        $result = $this->db->get($this->table);
        $city_list = $result->result_array();
        return $city_list;
    }
}


/* End of file Application_model.php */

