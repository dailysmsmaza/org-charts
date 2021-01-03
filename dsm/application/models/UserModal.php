<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function user_likes($login_user_id){
        $this->db->where(COL_USER_ID, $login_user_id);
        $this->db->order_by(COL_ID, DESCENDING);
        $result = $this->db->get(TBL_LIKE_IPADDRESS);
        $login_user = $result->result_array();

        foreach ($login_user as $login_user_key => $login_user_value) {

            $msg_id = $login_user_value[COL_SMS_ID];
            $this->db->where(COL_STATUS, ACTIVE);
            $this->db->where(COL_ID, $msg_id);
            $msg = $this->db->get(TBL_MESSAGE);
            $msg_array = $msg->result_array();
            
            foreach ($msg_array as $msg_key => $msg_value) {

                $user_id = $msg_value[COL_USER_ID];

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

                $msg_value = array_merge($msg_value, [COL_USER_NAME => $user_name]);
                $msg_value = array_merge($msg_value, [ARRAY_CATEGORIES => $categories_array]);
                $msg_value = array_merge($msg_value, ["is_liked" => true]);

                $data[$login_user_key] = $msg_value;
            }
   
        }
        // print_r($data);
        return $data;
    }

    function register($user_display_name, $user_name, $user_email, $notification_token){
        $this->db->where(COL_USER_EMAIL, $user_email);
        $result = $this->db->get(TBL_USER)->row();
        if(empty($result)){ 
            // insert the data.
            $data = array(COL_USER_DISPLAY_NAME=>$user_display_name, COL_USER_NAME=>$user_name, COL_USER_EMAIL=>$user_email, COL_USER_NOTIFICATION_TOKEN=>$notification_token);
            $this -> db -> insert(TBL_USER, $data);


        } else {
            // update the data.
            $this->db->where(COL_USER_EMAIL, $user_email);
            $data = array(COL_USER_DISPLAY_NAME=>$user_display_name, COL_USER_NAME=>$user_name, COL_USER_NOTIFICATION_TOKEN=>$notification_token );
            $this->db->update(TBL_USER, $data);
        }
        return $this->get_user_data($user_email);
    }

    function get_user_data($user_email){
        $this->db->where(COL_USER_EMAIL, $user_email);
        return $this->db->get(TBL_USER)->row();
    }

}


/* End of file Application_model.php */

