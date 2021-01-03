<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

    public $table = 'message'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_sms()
    {
        $result = $this->db->get($this->table);
        $sms_list = $result->result_array();
        return $sms_list;
    }


}

/* End of file Application_model.php */

