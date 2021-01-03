<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model
{
	public $table = 'admins'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	
	public function __construct()
	{
		$this->return_as = 'object';
    parent::__construct();
  }
}

/* End of file Profile_model.php */
?>

