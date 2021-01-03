<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModal extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function insert_user($post_data){
        $name = $post_data[COL_NAME];
        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $email = $post_data[COL_EMAIL];
        $password = $post_data[COL_PASSWORD];
        $is_passcode = $post_data[COL_IS_PASSCODE];
        $notification_token = $post_data[COL_NOTIFICATION_TOKEN];

        $data = array(COL_NAME => $name, 
            COL_MOBILE_NUMBER => $mobile_number, 
            COL_EMAIL => $email, 
            COL_PASSWORD => $password,
            COL_IS_PASSCODE => $is_passcode,
            COL_NOTIFICATION_TOKEN => $notification_token);

        $this->db->insert(TBL_USERS, $data);
        $user_id = $this->db->insert_id();

        $data = array(COL_USER_ID => $user_id, 
            COL_REPORT_MONTHLY => 0, 
            COL_NOTIFICATION => 0, 
            COL_LANGUAGE => "English");

        $this->db->insert(TBL_USER_SETTINGS, $data);

        return $this->get_user($user_id);
    }

    function get_user($user_id){
        $this->db->where(COL_ID, $user_id);
        $this->db->select(array(COL_ID, COL_NAME, COL_MOBILE_NUMBER, COL_EMAIL, COL_IS_PASSCODE));
        $result = $this->db->get(TBL_USERS);
        $user = $result->result_array();
        return $user;
    }

    function login($post_data){
        $email = $post_data[COL_EMAIL];
        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $password = $post_data[COL_PASSWORD];

        $where = array();
        if(!empty($mobile_number)){ 
            $where = array(COL_MOBILE_NUMBER => $mobile_number, COL_PASSWORD=>$password);

        } else if(!empty($email)) {
            $where = array(COL_EMAIL => $email, COL_PASSWORD=>$password);
        }
        $this->db->where($where);
        $user_id = $this->db->get(TBL_USERS)->row()->id;
        return $this->get_user($user_id);    
    }

    function change_password($post_data){
        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $password = $post_data[COL_PASSWORD];

        $this->db->where(COL_MOBILE_NUMBER, $mobile_number);

        $current_password = $this->db->get(TBL_USERS)->row()->password;

        $this->db->where(COL_MOBILE_NUMBER, $mobile_number);
        $data = array(COL_PASSWORD => $password);
        $update = $this->db->update(TBL_USERS, $data);
        $user_id = $this->db->get(TBL_USERS)->row()->id;

        $this->insert_password_reset($user_id, $current_password);

        return $this->get_user($user_id);    
    }

    function insert_password_reset($user_id, $password){
        $data = array(COL_USER_ID => $user_id, 
            COL_PASSWORD => $password);
        $this->db->insert(TBL_PASSWORD_RESET, $data);  
    }

    function user_exist($post_data)
    {
        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $email = $post_data[COL_EMAIL];

        $this->db->where(COL_MOBILE_NUMBER, $mobile_number)->or_where(COL_EMAIL, $email);
        $result = $this->db->get(TBL_USERS);
        return ($result->num_rows()) ? true : false;
    }

    function get_user_settings($user_id)
    {
        $this->db->where(COL_USER_ID, $user_id);
        $result = $this->db->get(TBL_USER_SETTINGS);
        return $result->result_array();
    }

    function update_user_settings($post_data)
    {
        $user_id = $post_data[COL_USER_ID];
        $report_monthly = $post_data[COL_REPORT_MONTHLY];
        $notification = $post_data[COL_NOTIFICATION];
        $language = $post_data[COL_LANGUAGE];

        $data = array();

        // Report Monthly
        if($report_monthly===0){
            $data [COL_REPORT_MONTHLY] = $report_monthly;
        } else if($report_monthly===1){
            $data [COL_REPORT_MONTHLY] = $report_monthly;
        }

        // Report Monthly
        if($notification===0){
            $data [COL_NOTIFICATION] = $notification;
        } else if($notification===1){
            $data [COL_NOTIFICATION] = $notification;
        }

        if(!empty($language)){
            $data [COL_LANGUAGE] = $language;
        }

        $this->db->where(COL_USER_ID, $user_id);
        $update = $this->db->update(TBL_USER_SETTINGS, $data);
        if($update){
            return true;
        } else {
            return false;
        }

    }

    function update_user($post_data)
    {
    	$data = array();

		$id = $post_data[COL_ID];

        $name = $post_data[COL_NAME];
        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $email = $post_data[COL_EMAIL];
        $is_passcode = $post_data[COL_IS_PASSCODE];
        $notification_token = $post_data[COL_NOTIFICATION_TOKEN];

        if(!empty($name)){
        	$data [COL_NAME] =  $name;
        }
        if(!empty($mobile_number)){
        	$data [COL_MOBILE_NUMBER] = $mobile_number;
        }
        if(!empty($email)){
        	$data [COL_EMAIL] = $email;
        }
        if(!empty($is_passcode)){
        	$data [COL_IS_PASSCODE] = $is_passcode;
        }
        if(!empty($notification_token)){
        	$data [COL_NOTIFICATION_TOKEN] = $notification_token;
        }
       
		$this->db->where(COL_ID, $id);
		$update = $this->db->update(TBL_USERS, $data);
		if($update){
			return true;
		} else {
			return false;
		}

    }

    function check_password_already_used($post_data){
        $is_exists = false;

        $mobile_number = $post_data[COL_MOBILE_NUMBER];
        $password = $post_data[COL_PASSWORD];

        $this->db->where_in(COL_MOBILE_NUMBER, $mobile_number);

        $current_password = $this->db->get(TBL_USERS)->row()->password;
        $user_id = $this->db->get(TBL_USERS)->row()->id;

        if(strcmp($current_password, $password) == 0){
            return true;
        }

        $this->db->where_in(COL_USER_ID, $user_id);
        $result = $this->db->get(TBL_PASSWORD_RESET);
        $user_list = $result->result_array();
        foreach($user_list as $user){
            $old_password = $user->password;
            if(strcmp($old_password, $password) == 0){
                $is_exists = true;
                break;
            }
        }

        return $is_exists;
    }

}


/* End of file Application_model.php */

