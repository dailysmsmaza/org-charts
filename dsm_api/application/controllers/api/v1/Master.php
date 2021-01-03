<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/api/v1/CommonApi.php';

class Master extends CommonApi {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function categories_get()
	{
		$req_params = $this->input->get();
		$cat_id = $req_params[COL_CAT_ID];

		$this->load->model('category_model');
		$categories = $this->category_model->get_categories($cat_id);
		$categories_count = count($categories);
		$this -> commonResponseJson( ($categories_count>0) ? 200 : 204, ($categories_count>0) ? "Success" : "No Category Found.", $categories);
	}

	public function add_get() {
		$this->load->model('sms_model');
		$messages = $this->sms_model->add_messages();
		$this -> commonResponseJson(200 , "Success", $messages);
	}
	
	/*public function sms_get()
	{
		$req_params = $this->input->get();
		$cat_id = $req_params[COL_CAT_ID];
		$page = $req_params[COL_PAGE];

		$this->load->model('sms_model');
		$messages = $this->sms_model->get_messages($cat_id, $page);
		$messages_count = count($messages);
		$this -> commonResponseJson(($messages_count>0) ? 200 : 204, ($messages_count>0) ? "Success" : "No Messages Found.", $messages);
	}*/
	
	public function sms_get()
	{
		$req_params = $this->input->get();
		$cat_id = $req_params[COL_CAT_ID];
		$page = $req_params[COL_PAGE];

		$this->load->model('sms_model');
		$messages = $this->sms_model->get_messages($cat_id, $page);
		$messages_count = count($messages);
		$this -> commonResponseJson(($messages_count>0) ? 200 : 204, ($messages_count>0) ? "Success" : "No Messages Found.", $messages);
	}
	
	public function sms_like_post()
	{
		$req_params = $this->input->post();
		$sms_id = $req_params["sms_id"];
		$this->load->model('sms_model');
		$messages = $this->sms_model->like_message($sms_id);
		$this -> commonResponseJson(200 , "Success", $messages);
	}
}
