<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form'));
		$this->load->library('session');
		$this->load->library(array('form_validation'));
	}
	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run()) {

			$this->load->model('admin/login_model');

			if ($this->login_model->log_in_correctly()) {
				$data = array(
					'username' => $this->input->post('username'),
					'currently_logged_in' => 1
				);
				$this->session->set_userdata($data);
				$this->redirect_home();
			} else {
				$this->load->view('admin/livetvadmin');
			}
		} else {
			$this->load->view('admin/livetvadmin');
		}
	}

	public function home()
	{
		$this->load->model('auth_model');
		$result['data'] = $this->auth_model->get_all_auth_key();
		$this->load->view('admin/header');
		$this->load->view('admin/home', $result);
	}

	public function redirect_home(){
		redirect(base_url('admin/main/home'));
	}

	public function add_auth_key()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/add_auth_key');

		/*Check submit button */
		if ($this->input->post('save')) {
			$data['auth_key'] = $this->input->post('auth_key');
			$this->load->model('auth_model');
			$auth_id = $this->auth_model->save_auth_key($data);
			if ($auth_id > 0) {
				$this->redirect_home();
			} else {
				echo "Insert error !";
			}
		}
	}
}
