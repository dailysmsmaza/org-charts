<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InsertData extends MY_Model {

    public $table = 'CrudOperation'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function insertdt(){
        $this->db->insert($this->table, $_POST);
        return $this->db->insert_id();
    }
}

/* End of file Application_model.php */