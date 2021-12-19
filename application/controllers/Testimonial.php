<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("testimonial_model");
        $this->load->library('form_validation');
        $this->load->library('pagination');
        if ($this->session->userdata('id') =="") {
            redirect("login");
        }  
        if($this->session->userdata("role")!=1){
        	redirect("login");
        }
    }

    /**
     * Testimonial List
     */
    public function index() {
        $data["page_title"] = "ORG Chart | Testimonial List";
        $data["heading_title"] = "Testimonial List";
        $this->load->view("admin/include/header", $data);
        $condition = " where is_delete=0";
        $data["total_testimonial"] = get_totalnumber_of_rows("testimonial_master",$condition);
        $page_num = $this->uri->segment(3);
        $config['base_url'] = base_url()."testimonial/index";
        $config['total_rows'] = get_totalnumber_of_rows("testimonial_master",$condition);       
        $config['per_page'] = 4;
        $config['use_page_numbers'] = TRUE;
        $data["testimonial"] = $this->testimonial_model->get_testimonial_list($config["per_page"],$page_num);
        $this->pagination->initialize($config);
        $this->load->view('admin/testimonial/testimonial_list', $data);
        $this->load->view("admin/include/footer");
    }

    /*
     * Get Company Employee Data
     */

    public function get_company_employee() {
        $company = $this->input->post("company");
        $data = $this->testimonial_model->get_company_employee($company);
        echo json_encode($data);
    }

    /*
     * Add Testimonial
     */

    public function add_testimonial() {
        $this->form_validation->set_rules('company', 'Company Name', 'required');       
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = "ORG Chart | Add Testimonial";
            $data["heading_title"] = "Add Testimonial";
            $this->load->view("admin/include/header", $data);
            $data["company"] = $this->testimonial_model->get_company_list();
            $this->load->view('admin/testimonial/add_testimonial', $data);
            $this->load->view("admin/include/footer");
        } else {
            $user = "";
            if ($this->input->post("employee") != "") {
                $user = $this->input->post("employee");
            } else {
                $user = $this->input->post("company");
            }
            // $exist_company = checkcolunm_exist("company_master", "company_name", $company_name);
            $message = $this->input->post("message");
            $data = array('user_id' => $user, "message" => $message);
            $result = $this->testimonial_model->insert($data);
            if ($result) {
                $this->session->set_flashdata("success", "Testimonial Add Successfully");
                redirect("testimonial");
            } else {
                $this->session->set_flashdata("fail", "Testimonial Not  Add Successfully");
                redirect("testimonial/add_testimonial");
            }
        }
    }

    /*
     * Edit Company
     */

    public function edit($id) {
        $this->form_validation->set_rules('company', 'Company Name', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data["page_title"] = " ORG Chart | Edit Testimonial";
            $data["heading_title"] = "Edit Testimonial";
            $this->load->view("admin/include/header",$data);
            $data["edit_testimonial"] = $this->testimonial_model->edit($id);
            $data["company"] = $this->testimonial_model->get_company_list();
            $this->load->view("admin/testimonial/edit_testimonial", $data);
            $this->load->view("admin/include/footer");
        } else {
            $user = "";
            if ($this->input->post("employee") != "") {
                $user = $this->input->post("employee");
            } else {
                $user = $this->input->post("company");
            }
            $message = $this->input->post("message");
            $data = array('user_id' => $user, "message" => $message);
            $result = $this->testimonial_model->update($data, $id);
            if ($result) {
                $this->session->set_flashdata("success", "Company Update Successfully");
                redirect("testimonial");
            } else {
                $this->session->set_flashdata("fail", "Company Not  Update Successfully");
                redirect("testimonial/edit/" . $id);
            }
        }
    }

    /*
     * Change Status
     */

    public function changestatus($status, $id) {        
        $data = array('status' => $status);
        $result = $this->testimonial_model->changestatus($data, $id);
        if ($result) {
            $this->session->set_flashdata("success", "Testimonial Status Update Successfully");
            redirect("testimonial");
        } else {
            $this->session->set_flashdata("fail", "Testimonial Status Not  Update Successfully");
            redirect("testimonial");
        }
    }

    /*
     * Delete Testimonial
     */

    public function delete($id) {        
        $result = $this->testimonial_model->delete($id);
        if ($result) {
            $this->session->set_flashdata("success", "Testimonial Delete Successfully");
            redirect("testimonial");
        } else {
            $this->session->set_flashdata("fail", "Testimonial Not  Delete Successfully");
            redirect("testimonial");
        }
    }

}
