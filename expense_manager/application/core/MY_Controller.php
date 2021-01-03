<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $the_view = '';
    protected $data = array();
    protected $template;

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_function_model', 'common');
        $this->data['is_CKEditor'] = FALSE;
        $this->data['is_GRID'] = TRUE;

        $this->load->model('Site_settings_model', 'setting');
        $this->data['setting'] = $this->setting->get(1); /* Get a site setting */
    }

    protected function render($the_view = NULL, $template = 'gui_master') {
        if ($template == 'json' || $this->input->is_ajax_request()) {
            $this->output->set_content_type("application/json")->set_status_header(200)->set_output($this->data);
        } elseif (is_null($template)) {
            $this->load->view($the_view, $this->data);
        } else {

            $this->data['view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
            $this->load->view('templates/' . $template . '_view', $this->data);
        }
    }

    /** set a page title */
    public function setPageTitle($page_title) {
        $this->data['page_title'] = $page_title;
    }

    protected function getSql() {
        return $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
    }

}

class Auth_Controller extends MY_Controller {

    //protected $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Site_settings_model', 'setting');

        /** get iste setting */
        $this->data['setting'] = $this->setting->get(1); /* Get a site setting */
    }

    protected function render($the_view = NULL, $template = 'admin_master') {
        parent::render($the_view, $template);
    }

}

class Admin_Controller extends MY_Controller {

    protected $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('Site_settings_model', 'setting');

        /** get iste setting */
        $this->data['setting'] = $this->setting->get(1); /* Get a site setting */
    }

    protected function render($the_view = NULL, $template = 'admin_master') {
        parent::render($the_view, $template);
    }

}
