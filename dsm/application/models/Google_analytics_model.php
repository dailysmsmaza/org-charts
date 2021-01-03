<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Google_analytics_model extends MY_Model
{
	public $table = 'google_analytics'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	
	public function __construct()
	{
		$this->return_as = 'object';
    parent::__construct();
  }
}

/* End of file User_model.php */
