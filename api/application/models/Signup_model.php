<?php
/**
 * Created by PhpStorm.
 * User: Krupa
 * Date: 7/5/18
 * Time: 7:06 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup_model extends MY_Model {

    public $table = 'user_master'; // you MUST mention the table name
    public $primary_key = 'user_id'; // you MUST mention the primary key

    public $user_name = 'user_name';

    public function __construct() {
        $this->return_as = 'object';

        parent::__construct();
    }

    function signup_user($userData)
    {
        print_r($userData);
        $userDict =
        print_r($value['user_name']);
//        $this->db->insert($this->table, $userData);
//        return null;
    }

}

/* End of file Application_model.php */
