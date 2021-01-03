<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wallpaper_model extends MY_Model {

    public $table = 'wallpaper'; // you MUST mention the table name
    public $primary_key = 'wallpaper_id'; // you MUST mention the primary key

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function get_datatables($sql_details) {
        $this->load->library('datatables_ssp');
        $this->load->helper('text');

        //Datatables_ssp::$extra_columns = 'created_at';

        $delete_all = array(
            'customfilter' => 'wallpaper_id',
            'db' => 'wallpaper_id',
            'formatter' => function($row) {
                return get_delete_all($row);
            }
        );	
	$wall_name = array(
            'customfilter' => 'wall_name',
            'db' => 'wall_name',
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
        $category_id = array(
            'customfilter' => 'category_id',
            'db' => 'category_id',
            'formatter' => function($category_id, $row) {
            	return get_category_id($category_id);
            }
        );

        
        $get_edit = array(
            'customfilter' => 'wallpaper_id',
            'db' => 'wallpaper_id',
            'formatter' => function($id) {
                return get_edit($id, 'admin/wallpaper/edit'); /// $id = row_id , method path 
            }
        );
        $delete = array(
            'customfilter' => 'wallpaper_id',
            'db' => 'wallpaper_id',
            'formatter' => function($id) {
                return get_delete($id);
            }
        );

        $data_table = array_values(compact('delete_all','wall_name', 'app_name','app_id', 'category_id' , 'get_edit', 'delete'));

        

        $columns = array();

        foreach ($data_table as $data_key => $value) {
            $value['dt'] = $data_key;
            $columns[] = $value;
        }
		
        function get_app_name($app_id) {
            $ci = & get_instance();
            $ci->db->select('*');
            $ci->db->where('app_id', $app_id);
            $app = $ci->db->get('application');
            $val = $app->row();
			if($val)
			{
            	return $val->app_name;
			}
			else
			{
				return "";
			}
        }
        function get_app_id($app_id) {
            $ci = & get_instance();
            $ci->db->select('*');
            $ci->db->where('app_id', $app_id);
            $app = $ci->db->get('application');
            $val = $app->row();
			if($val)
			{
            	return $val->app_id;
			}
			else
			{
				return "";
			}
            
        }
        
        function get_category_id($category_id) {
            $ci = & get_instance();
            $ci->db->select('*');
            $ci->db->where('category_id', $category_id);
            $category = $ci->db->get('category');
            $val = $category->row();
			if($val)
			{
            	return $val->category_name;
			}
			else
			{
				return "";
			}
          
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
        
		$this->db->select('wallpaper_image,wall_img_thumb');
        $this->db->where('wallpaper_id', $id);
        $query = $this->db->get('wallpaper_img');
        $walls = $query->result_array();
        foreach ($walls as $key => $wall) {
            if ($wall['wallpaper_image'] != '') {
                if (file_exists('./' . $wall['wallpaper_image'])) {
                    unlink('./' . $wall['wallpaper_image']);
                }
                if ($wall['wall_img_thumb'] != '') {
                if (file_exists('./' . $wall['wall_img_thumb'])) {
                    unlink('./' . $wall['wall_img_thumb']);
                }
            }
        }
        }
        $this->db->where('wallpaper_id', $id);
        $this->db->delete('wallpaper_img');
		
        $this->db->where('wallpaper_id', $id);
        if ($this->db->delete('wallpaper'))
            return true;
        else
            return false;
    }
        function delete_all($ids) {

        foreach ($ids as $id) {
            $this->db->select('wallpaper_image,wall_img_thumb');
        $this->db->where('wallpaper_id', $id);
        $query = $this->db->get('wallpaper_img');
        $walls = $query->result_array();
        foreach ($walls as $key => $wall) {
            if ($wall['wallpaper_image'] != '') {
                if (file_exists('./' . $wall['wallpaper_image'])) {
                    unlink('./' . $wall['wallpaper_image']);
                }
                if ($wall['wall_img_thumb'] != '') {
                if (file_exists('./' . $wall['wall_img_thumb'])) {
                    unlink('./' . $wall['wall_img_thumb']);
                }
            }
        }
        }   

        }
        $this->db->where_in('wallpaper_id', $id);
        $this->db->delete('wallpaper_img');
        
        $this->db->where_in('wallpaper_id', $ids);
        if ($this->db->delete('wallpaper'))
            return true;
        else
            return false;
    
	}
    
    function getCategory_all($medaiId) {
        $html = "";
        $this->db->select('*');
        $this->db->where('app_id', $medaiId);
        $query = $this->db->get('category');
        $html .= ' <div class="form-group m-form__group row"><label class="col-form-label col-lg-3 col-sm-12" for="app_name">Category Name<span class="text-danger">*</span> </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">';
        $html .= ' <select  class="form-control input-lg m-input" name="category_id" id="category_id"  required data-msg-required="Please select category.">';
        $html . ' <option value="">Select Category</option>';
        $datas = $query->result_array();
        foreach ($datas as $key => $data_val) {
            $html .= '<option value="' . $data_val['category_id'] . '">' . $data_val['category_name'] . '</option>';
        }
        $html .= '  </select>
                    </div></div>';
        return $html;
    }
	
	function getCategory_by_id($id) {
        $this->db->select('*');
        $this->db->where('app_id', $id);
        $query = $this->db->get('category');
        return $query->result_array();
    }
	
	function get_image_by_id($id) {
        $this->db->select('*');
        $this->db->where_in('wallpaper_id', $id);
        $result = $this->db->get('wallpaper_img');
        return $result->result_array();
    }
	
	function delete_image($id, $action) {
        $message = '';
        if ($action == 'photo') {
            $this->db->select('wallpaper_image,wall_img_thumb');
            $this->db->where('id', $id);
            $query = $this->db->get('wallpaper_img');
            $value = $query->row();
            if ($value->wallpaper_image != '') {
                if (file_exists('./' . $value->wallpaper_image)) {
                    unlink('./' . $value->wallpaper_image);
                }
            }
            if ($value->wall_img_thumb != '') {
                if (file_exists('./' . $value->wall_img_thumb)) {
                    unlink('./' . $value->wall_img_thumb);
                }
            }
        }
        $this->db->where('id', $id);
        $delete = $this->db->delete('wallpaper_img');
        if ($delete == TRUE) {
            $message = 'success';
        } else {
            $message = 'error';
        }
        return $message;
    }
        function get_wallpaper_by_categoryId($category_id,$limit,$offset){
            $this->db->select('wallpaper.*,wallpaper_img.*,category.category_name,category.category_image,application.app_name');
            $this->db->join('wallpaper_img', 'wallpaper_img.wallpaper_id=wallpaper.wallpaper_id','left');
            $this->db->join('category', 'category.category_id=wallpaper.category_id','left');
            $this->db->join('application', 'application.app_id=wallpaper.app_id','left');
            $this->db->where('wallpaper.category_id',$category_id);
             $this->db->limit($offset,$limit);
            $result = $this->db->get('wallpaper');
            $wallpaper_list =  $result->result_array();
            return $wallpaper_list;
    }
            function get_wallpaper_by_categoryidtotal($category_id){
            $this->db->select('wallpaper.*,wallpaper_img.*,category.category_name,category.category_image,application.app_name');
            $this->db->join('wallpaper_img', 'wallpaper_img.wallpaper_id=wallpaper.wallpaper_id','left');
            $this->db->join('category', 'category.category_id=wallpaper.category_id','left');
            $this->db->join('application', 'application.app_id=wallpaper.app_id','left');
            $this->db->where('wallpaper.category_id',$category_id);
            $result = $this->db->get('wallpaper');
            $wallpaper_list =  $result->result_array();
            return $wallpaper_list;
    }
    function record_count() {
		$result = $this->db->get('wallpaper');
		return $result->num_rows();
    }
}


/* End of file Application_model.php */

