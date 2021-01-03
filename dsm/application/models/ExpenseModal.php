<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ExpenseModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }


    function add_user_expense(){
        echo $user_id = $this->input->post("user_id");
        // $cat_id = $this->input->post(COL_CAT_ID);
        // $title = $this->input->post(COL_TITLE);
        // $price = $this->input->post(COL_PRICE);
        // $description = $this->input->post(COL_DESCRIPTION);
        // $location = $this->input->post(COL_LOCATION);
        // $is_online = $this->input->post(COL_IS_ONLINE);
        
        // $data = array(
        //     COL_USER_ID => $user_id, 
        //     COL_CAT_ID => $cat_id, 
        //     COL_TITLE => $title,
        //     COL_PRICE => $price,
        //     COL_DESCRIPTION => $description,
        //     COL_LOCATION => $location,
        //     COL_IS_ONLINE => $is_online
        // );
        
        // print_r($data);
        // $this->db->insert(TBL_USER_EXPENSE, $data);  
    }

}


/* End of file Application_model.php */

