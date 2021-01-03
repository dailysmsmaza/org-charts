<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends MY_Model {

    public $table = 'application'; // you MUST mention the table name
    public $primary_key = 'app_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_datatables($sql_details) {
        $this->load->library('datatables_ssp');
        $this->load->helper('text');

        //Datatables_ssp::$extra_columns = 'created_at';

        $delete_all = array(
            'customfilter' => 'app_id',
            'db' => 'app_id',
            'formatter' => function($row) {
                return get_delete_all($row);
            }
        );
        $app_name = array(
            'customfilter' => 'app_name',
            'db' => 'app_name'
        );
        $app_id = array(
            'customfilter' => 'app_id',
            'db' => 'app_id'
        );
        $get_edit = array(
            'customfilter' => 'app_id',
            'db' => 'app_id',
            'formatter' => function($id) {
                return get_edit($id, 'admin/application/edit'); /// $id = row_id , method path 
            }
        );
        $delete = array(
            'customfilter' => 'app_id',
            'db' => 'app_id',
            'formatter' => function($id) {
                return get_delete($id);
            }
        );

        $data_table = array_values(compact('delete_all', 'app_name','app_id', 'get_edit', 'delete'));

        

        $columns = array();

        foreach ($data_table as $data_key => $value) {
            $value['dt'] = $data_key;
            $columns[] = $value;
        }

        return json_encode(
                Datatables_ssp::simple($_GET, $sql_details, $this->table, $this->primary_key, $columns, $myjoin = '', $where = '')
        );
    }

}

/* End of file Application_model.php */
