<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City_model extends MY_Model {

    public $table = 'city_master'; // you MUST mention the table name
    public $primary_key = 'city_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';

        parent::__construct();
    }

    function get_cities($currentPage) {

        $this->db->select('city_id,city_name');
//        $this->db->where('city_id', 5);
        $result = $this->db->get($this->table);
        $city_list = $result->result_array();

        $totalPages = ceil(count($result->result_array()) / 10);

        $city_list_final = ['Cities' => $city_list, 'Pagination' => array('TotalPages'=>$totalPages,"CurrentPage" => $currentPage)];

        return $city_list_final;
    }

//    function paginationSetup($urlPostfix) {
//        $config = array();
//        $config["base_url"] = base_url()."api/master/.$urlPostfix./";
//        $config["total_rows"] = $count_wallpaper;
//        $config["per_page"] = 10;
//        $config['num_links'] = $count_wallpaper;
//        $config['use_page_numbers'] = TRUE;
//        $config["uri_segment"] = 5;
//        $this->pagination->initialize($config);
//    }

    function get_total_city_records() {
        $result = $this->db->get($this->table);
        return $result->num_rows();
    }
}

/* End of file Application_model.php */

