<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PopularSmsModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }


    function get_popular_sms($page, $login_user_id)
    {
    	$data = array();

        $limit = 10;
        $start_from = ($page-1) * $limit;
        $this->db->limit($limit, $start_from);
        $this->db->order_by(COL_LIKES, DESCENDING);
        $this->db->where(COL_STATUS, ACTIVE);
        $message = $this->db->get(TBL_MESSAGE);
        $message_array = $message->result_array();
        foreach ($message_array as $message_key => $message_value) {

        	$msg_id = $message_value[COL_ID];
        	$user_id = $message_value[COL_USER_ID];

        	$this->db->where(COL_SMS_ID, $msg_id);
        	$msg_sub = $this->db->get(TBL_MESSAGE_SUB);
        	$msg_sub_array = $msg_sub->result_array();
        	
        	$categories_array = array();

        	foreach ($msg_sub_array as $msg_sub_key => $msg_sub_value) {
        		$msg_sub_cat_id = $msg_sub_value[COL_CAT_ID];

        		$this->db->where(COL_CAT_ID, $msg_sub_cat_id);
	        	$category_name = $this->db->get(TBL_CATEGORY)->row()->cat_name;

	        	array_push($categories_array, $category_name);	   
        	}

        	$this->db->where(COL_USER_ID, $user_id);
	        $user_name = $this->db->get(TBL_USER)->row()->username;

	        $message_value = array_merge($message_value, [COL_USER_NAME => $user_name]);
	        $message_value = array_merge($message_value, [ARRAY_CATEGORIES => $categories_array]);

            // IS_LIKED_MESSAGE
            $this->db->where(COL_USER_ID, $login_user_id);
            $this->db->where(COL_SMS_ID, $msg_id);
            $is_liked = $this->db->get(TBL_LIKE_IPADDRESS)->row();
            if(!empty($is_liked)){
                $message_value = array_merge($message_value, ["is_liked" => true]);
            } else {
                $message_value = array_merge($message_value, ["is_liked" => false]);
            }

        	$data[$message_key] = $message_value;
        }
        return $data;
    }

}


/* End of file Application_model.php */

