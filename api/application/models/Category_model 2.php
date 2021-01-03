<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

    public $table = 'category'; // you MUST mention the table name
    public $primary_key = 'category_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_datatables($sql_details) {
        $this->load->library('datatables_ssp');
        $this->load->helper('text');

        //Datatables_ssp::$extra_columns = 'created_at';

        $delete_all = array(
            'customfilter' => 'category_id',
            'db' => 'category_id',
            'formatter' => function($row) {
                return get_delete_all($row);
            }
        );
        $category_name = array(
            'customfilter' => 'category_name',
            'db' => 'category_name'
        );
        
        $app_name = array(
            'customfilter' => 'app_id',
            'db' => 'app_id',
            'formatter' => function($app_id, $row) {
                return get_app_name($app_id);
            }
        );
        $app_id = array(
            'customfilter' => 'app_id',
            'db' => 'app_id',
            'formatter' => function($app_id, $row) {
                return get_app_id($app_id);
            }
        );
        $get_edit = array(
            'customfilter' => 'category_id',
            'db' => 'category_id',
            'formatter' => function($id) {
                return get_edit($id, 'admin/category/edit'); /// $id = row_id , method path 
            }
        );
        $delete = array(
            'customfilter' => 'category_id',
            'db' => 'category_id',
            'formatter' => function($id) {
                return get_delete($id);
            }
        );

        $data_table = array_values(compact('delete_all', 'category_name', 'app_name' ,'app_id', 'get_edit', 'delete'));

        

        $columns = array();

        foreach ($data_table as $data_key => $value) {
            $value['dt'] = $data_key;
            $columns[] = $value;
        }
		
        function get_app_name($app_id) {
            $ci = & get_instance();
            $ci->db->select('*');
            $ci->db->where('app_id', $app_id);
            $category = $ci->db->get('application');
            $val = $category->row();
            return $val->app_name;
        }
       function get_app_id($app_id) {
            $ci = & get_instance();
            $ci->db->select('*');
            $ci->db->where('app_id', $app_id);
            $category = $ci->db->get('application');
            $val = $category->row();
            return $val->app_id;
        }
        
        return json_encode(
                Datatables_ssp::simple($_GET, $sql_details, $this->table, $this->primary_key, $columns, $myjoin = '', $where = '')
        );
    }
    
    function getAppname_all(){
    	
        $this->db->select('*');
        $query = $this->db->get('application');
        $datas = $query->result_array();
        return $datas;
  		
    }
    
    function delete_record($id) {
        $this->db->select('category_image');
        $this->db->where('category_id', $id);
        $query = $this->db->get('category');
        $categorys = $query->result_array();
        foreach ($categorys as $key => $category) {
            if ($category['category_image'] != '') {
                if (file_exists('./' . $category['category_image'])) {
                    unlink('./' . $category['category_image']);
                }
            }
        }
        
        $this->db->where('category_id', $id);
        if ($this->db->delete('category'))
            return true;
        else
            return false;
    }
    
    function delete_all($ids) {

        foreach ($ids as $id) {
            

            $this->db->select('category_image');
            $this->db->where('category_id', $id);
            $query = $this->db->get('category');
            $categorys = $query->result_array();
            foreach ($categorys as $key => $category) {
                if ($category['category_image'] != '') {
                    if (file_exists('./' . $category['category_image'])) {
                        unlink('./' . $category['category_image']);
                    }
                }
            }
        }
        $this->db->where_in('category_id', $ids);
        if ($this->db->delete('category'))
            return true;
        else
            return false;
    }
    function get_category_by_app_id($app_id){
    $this->db->select('category.*,application.app_name');
     $this->db->join('application', 'application.app_id=category.app_id','left');
    $this->db->where('category.app_id',$app_id);
    $result = $this->db->get('category');
    $category_list =  $result->result_array();
    return $category_list;
    }
    function record_count() {
		$result = $this->db->get('category');
		return $result->num_rows();
    }

}

/* End of file Application_model.php */

