<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UpdateData extends MY_Model {

    public $table = 'CrudOperation'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function updatedt(){
        $phone_number = $this->input->get('phone_number');
        $this->db->where('phone_number', $phone_number);
        $this->db->update($this->table, $_GET);
        return true;
    }
}

/* End of file Application_model.php */