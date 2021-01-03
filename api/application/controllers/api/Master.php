<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/api/CommonAPI.php';


class Master extends CommonAPI {

    function __construct() {
        parent::__construct();
            $this->load->library('pagination');
            $this->load->model('City_model', 'city');
            $this->load->model('Category_model', 'category');
            $this->load->model('Signup_model', 'signup');
            $this->load->model('SubCategory_model', 'subcategory');
            $this->load->model('Register_model', 'register');
            $this->load->model('Get_user_modal', 'get_user');
            $this->load->model('Get_particular_user_modal', 'get_particular_user_modal');
            $this->load->model('FirebasePushNotification', 'firebase_push_notification');
            $this->load->model('LastSmsModal', 'last_sms_modal');
    }

	public function getAllSms_get() {
        $get_sms =  $this->last_sms_modal->get_sms();
        $this -> commonApiController($get_sms);
    }

    public function getAllCities_get($currentPage=1) {
        $get_cities =  $this->city->get_cities($currentPage);
        $total_records = $this->city->get_total_city_records();
        $this->commonApiController($get_cities, $total_records);
    }

    public function getAllCategories_get() {
        $get_categories =  $this->category->get_categories();
        $this -> commonApiController($get_categories);
    }

    public function getAllSubCategories_get() {
        $get_sub_categories = $this->subcategory->get_sub_categories();
        $this -> commonApiController($get_sub_categories);
    }

    public function getUsers_get() {
        $get_users =  $this->get_user->get_users();
        $this -> commonApiController($get_users);
    }

    public function getUser_get() {
        $get_user =  $this->get_particular_user_modal->get_user();
        $this -> commonApiController($get_user);
    }

    public function register_post() {
        $insert_data =  $this->register->insert_data();
        $this -> commonApiController($insert_data);
    }

    public function sendPushNotification_get() {
        $send_notification =  $this->firebase_push_notification->sendFCM();
        $this -> commonApiController($send_notification);
    }

    public function signupUser_post() {

        $userData = $this->getPostParams();

//        $requestParams = array();
//        $requestParams = $userData;
//        $requestParams = $userData['UserName'];

//        $requestParams['user_name'] = $userData->UserName;
//
//        print_r($userData);exit;

        $this->signup->signup_user($userData);
//        $this->commonApiController($userData);
    }

}