<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_categories($p_id){
        $this->db->where(COL_P_ID, $p_id);
        $result_categories = $this->db->get(TBL_CATEGORY);
        return $result_categories->result_array();
    }

}

/* End of file Application_model.php */

