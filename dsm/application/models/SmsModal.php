<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SmsModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_sms($page, $cat_id, $login_user_id){
        $data = array();
        $limit = 10;
        $start_from = ($page-1) * $limit;
        $this->db->limit($limit, $start_from);
        $this->db->order_by(COL_ID, DESCENDING);
        $this->db->where(COL_CAT_ID, $cat_id);
        $msg_sub = $this->db->get(TBL_MESSAGE_SUB);
        $msg_sub_array = $msg_sub->result_array();
        if(!empty($msg_sub_array)){
                
            // Category Data
            $this->db->where(COL_CAT_ID, $cat_id);
            $category = $this->db->get(TBL_CATEGORY)->row();
            $data = array_merge($data, [COL_CAT_NAME => $category->cat_name]);

            $msg_data_array = array();

            foreach ($msg_sub_array as $msg_key => $msg_value) {

                $this->db->where(COL_STATUS, ACTIVE);
                $this->db->where(COL_ID, $msg_value[COL_SMS_ID]);
                $msg = $this->db->get(TBL_MESSAGE);
                $msg_array = $msg->result_array();
                foreach ($msg_array as $msg_key => $msg_value) {
                    $sms_id = $msg_value[COL_ID];

                    // USER Data
                    $this->db->where(COL_USER_ID, $msg_value[COL_USER_ID]);
                    $user = $this->db->get(TBL_USER)->row();
                    $msg_value = array_merge($msg_value, [COL_USER_NAME => $user->username]);

                    // IS_LIKED_MESSAGE
                    $this->db->where(COL_USER_ID, $login_user_id);
                    $this->db->where(COL_SMS_ID, $sms_id);
                    $is_liked = $this->db->get(TBL_LIKE_IPADDRESS)->row();
                    if(!empty($is_liked)){
                        $msg_value = array_merge($msg_value, ["is_liked" => true]);
                    } else {
                        $msg_value = array_merge($msg_value, ["is_liked" => false]);
                    }

                    array_push($msg_data_array, $msg_value);
                }
            }
            $data = array_merge($data, [ARRAY_MESSAGES => $msg_data_array]);
            return $data;
        }
        return null;
    }

    function like_sms($user_id, $sms_id) {
        $this->db->where(COL_ID, $sms_id);
        $likes = $this->db->get(TBL_MESSAGE)->row()->likes;

        $this->db->where(COL_ID, $sms_id);
        $data = array(COL_LIKES => ($likes+1) );
        $update = $this->db->update(TBL_MESSAGE, $data);


        $this->db->where(COL_SMS_ID, $sms_id);
        $this->db->where(COL_USER_ID, $user_id);
        $is_like = $this->db->get(TBL_LIKE_IPADDRESS)->row();
        if(empty($is_like)){
            $data = array(COL_SMS_ID=>$sms_id, COL_USER_ID=>$user_id);
            return $this -> db -> insert(TBL_LIKE_IPADDRESS, $data);

        } else {
            $this->db->where(COL_SMS_ID, $sms_id);
            $this->db->where(COL_USER_ID, $user_id);
            return $this -> db -> delete(TBL_LIKE_IPADDRESS);
        }
    }
    
}

/* End of file Application_model.php */

