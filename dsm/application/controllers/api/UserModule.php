<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/api/CommonAPI.php';

class UserModule extends CommonAPI {

    function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('City_model', 'city');
        $this->load->model('Signup_model', 'signup');
    }

    public function loginUser_post() {
//        $userData = $this->getPostParams();
//        print_r($userData);
        $this->commonApiController("aa");
    }

    public function getAllCities_get($currentPage=1) {
        $get_cities =  $this->city->get_cities($currentPage);
        $total_records = $this->city->get_total_city_records();
        $this->commonApiController($get_cities, $total_records);

    }

}