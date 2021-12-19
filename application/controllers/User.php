<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("form");
        $this->load->model("document_model");
        $this->load->model("company_model");
        $this->load->library('form_validation');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");     
        $this->load->library('pagination');        
        if ($this->session->userdata('id')=="") {
            redirect("login");
        }        

    }

    /**
     * User List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | User";
        $data["heading_title"] = "Users List";
            
        $page_num = "";
        $this->load->view("admin/include/header",$data);
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        if ($search != "") {
            $page_num = isset($_GET["per_page"]) ? $_GET["per_page"] : "";
            $config['base_url'] = base_url()."user/index?search=".$search;
            $condition = " where first_name Like '%$search%' or last_name Like'%$search%' or email Like '%$search%' or phone Like '%$search%' and  role = 1 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            $config['page_query_string'] = TRUE;
            $config['enable_query_strings'] = TRUE;

            $data["total_user"] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query(); 
        }else{           
            $page_num = $this->uri->segment(3);
            $config['base_url'] = base_url()."user/index";
            $condition = " where role =1 and is_delete=0";
            $config['total_rows'] = get_totalnumber_of_rows("user_master",$condition);
            //echo $this->db->last_query();
            $data["total_user"] = get_totalnumber_of_rows("user_master",$condition);;
        }
        
       
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $data["user_list"] = $this->user_model->get_user_list($search,$config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/user/user_list', $data);
        $this->load->view("admin/include/footer");
    }
    
    /*

}
