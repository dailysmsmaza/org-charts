<?php

class Category_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_categories($id) {
		$query = $this->db->select('category.cat_id, category.cat_name, category.cat_img, category.time, category_sub.cat_order, category.all_sms')
				->from('category_sub')
				->join('category', 'category_sub.cat_id=category.cat_id')
				->where('category_sub.p_id', $id)
				->get();
		return $query->result();
	}

}

?>