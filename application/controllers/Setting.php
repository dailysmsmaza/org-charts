<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * This Controller Used For Manage All Settings
*/
class Setting extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('commonfunction_helper');
        $this->load->library('form_validation','french');
        $this->load->helper("inflector");
        $this->load->helper("text");
        $this->load->helper("url");        
    }
    public function index(){
        $data["page_title"] = "Setting | ORG Chart";
        $data["heading_title"] = "Setting";
        $this->load->view("admin/include/header",$data);        
        $this->load->view("admin/setting/setting");
        $this->load->view("admin/include/footer");
    }

    
    /*
     * Update General Setting
    */
     public function update_generalsetting(){        
        
        if(!empty($_POST)){
            $metadata = $_POST;
            foreach ($metadata as $key => $value) {
                $this->db->where('meta_key', $key);
                $this->db->set('meta_value', $value);
                $this->db->update("setting");
            }
            if (!empty($_FILES["logo"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["logo"]["name"]);

                $this->db->where('meta_key',"logo");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");

                $res = $this->do_upload('logo', $filename, 'assets/setting/', 'jpg|jpeg|png');            
            }
           if (!empty($_FILES["favicon"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["favicon"]["name"]);
                
                $this->db->where('meta_key',"favicon");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");

                $res = $this->do_upload('favicon', $filename, 'assets/setting/', 'jpg|jpeg|png');
            }
            redirect("setting");
        }        
    }   

    /*
     * Landing Page
    */
    public function landing_page(){
        $data["page_title"]     = "Landing Page Setting | ORG Chart";
        $data["main_heading"]   =  "Landing Page Setting";
        $data["heading_title"]  = "Header Section";
        $data["heading_title2"] = "Middle Section";
        $data["heading_title3"] = "Third Section";
        $data["heading_title4"] = "Fourth Section";
        $this->load->view("admin/include/header",$data);        
        $this->load->view("admin/setting/landing_page");
        $this->load->view("admin/include/footer");
    }

    /*
     * Landing Page Setting Update
     */
    public function update_headersection()
    {
        if(!empty($_POST)){
            $metadata = $_POST;

            foreach ($metadata as $key => $value) {
                $this->db->where('meta_key', $key);
                $this->db->set('meta_value', $value);
                $this->db->update("setting");
            }
            if (!empty($_FILES["home_banner"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["home_banner"]["name"]);

                $this->db->where('meta_key',"home_banner");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");

                $res = $this->do_upload('home_banner', $filename, 'assets/setting/', 'jpg|jpeg|png');            
            }
            redirect("setting/landing_page");
        }
    }

    /*
     * Landing Page Middel Section Setting Update
     */
    public function update_middelsection()
    {
        if(!empty($_POST)){
            $metadata = $_POST;
            //print_r($metadata);exit;
            foreach ($metadata as $key => $value) {
                $this->db->where('meta_key', $key);
                $this->db->set('meta_value', $value);
                $this->db->update("setting");
            }
            if (!empty($_FILES["home_middelbanner"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["home_middelbanner"]["name"]);

                $this->db->where('meta_key',"home_middelbanner");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");

                $res = $this->do_upload('home_middelbanner', $filename, 'assets/setting/', 'jpg|jpeg|png');            
            }
            redirect("setting/landing_page");
        }
    }

    /*
     * Landing Page Third Section Setting Update
     */
    public function update_thirdsection()
    {
        if (!empty($_FILES["testimonial_banner"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["testimonial_banner"]["name"]);
                $this->db->where('meta_key',"testimonial_banner");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");
                $res = $this->do_upload('testimonial_banner', $filename, 'assets/setting/', 'jpg|jpeg|png');                        
            redirect("setting/landing_page");
        }
    }

    /*
     * Landing Page Fourth Section Setting Update
     */
    public function update_fourthsection()
    {
        if(!empty($_POST)){
            $metadata = $_POST;
            //print_r($metadata);exit;
            foreach ($metadata as $key => $value) {
                $this->db->where('meta_key', $key);
                $this->db->set('meta_value', $value);
                $this->db->update("setting");
            }
            if (!empty($_FILES["home_fourthsectionbanner"]["name"])) {
                $filename = underscore(date("dmY_his") . '_' . $_FILES["home_fourthsectionbanner"]["name"]);

                $this->db->where('meta_key',"home_fourthsectionbanner");
                $this->db->set('meta_value', $filename);
                $this->db->update("setting");

                $res = $this->do_upload('home_fourthsectionbanner', $filename, 'assets/setting/', 'jpg|jpeg|png');            
            }
            redirect("setting/landing_page");
        }
    }

    /*
     * Image Upload Do Upload
     */

    function do_upload($control, $filename, $upload_path, $file_format) {
        $config['upload_path'] = $upload_path;
        $config['file_name'] = $filename;
        $config['allowed_types'] = $file_format;
        $config['remove_spaces'] = FALSE;
        $config['max_size'] = '0';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($control)) {
            echo $this->upload->display_errors();
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
