<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template_model extends MY_Model {

    public $table = 'email_template'; // you MUST mention the table name
    public $primary_key = 'email_template_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        parent::__construct();
    }

    function get_datatables($sql_details) {
        $this->load->library('datatables_ssp');
        $this->load->helper('text');

        //Datatables_ssp::$extra_columns = 'created_at';

        $delete_all = array(
            'customfilter' => 'email_template_id',
            'db' => 'email_template_id',
            'formatter' => function($row) {
                return get_delete_all($row);
            }
        );
        $email_template_title = array(
            'customfilter' => 'email_template_title',
            'db' => 'email_template_title',
        );
        $get_edit = array(
            'customfilter' => 'email_template_id',
            'db' => 'email_template_id',
            'formatter' => function($id) {
                return get_edit($id, 'admin/email_template/edit'); /// $id = row_id , method path 
            }
        );
        $delete = array(
            'customfilter' => 'email_template_id',
            'db' => 'email_template_id',
            'formatter' => function($id) {
                return get_delete($id);
            }
        );


        $data_table = array_values(compact('delete_all', 'email_template_title', 'get_edit', 'delete'));

        $columns = array();

        foreach ($data_table as $data_key => $value) {
            $value['dt'] = $data_key;
            $columns[] = $value;
        }

        return json_encode(
                Datatables_ssp::simple($_GET, $sql_details, $this->table, $this->primary_key, $columns, $myjoin = '', $where = '')
        );
    }

    function get_email_template_by_id($id) {
        $this->db->where('email_template_id', $id);
        $result = $this->db->get('email_template')->row();
        return $result;
    }

}

/* End of file User_model.php */
