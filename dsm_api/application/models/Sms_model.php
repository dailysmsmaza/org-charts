<?php

class Sms_model extends CI_Model {
	

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/*public function get_messages($id, $page) {
		$limit = 10;
		$start_from = ($page-1) * $limit;
		$query = $this->db->select('message.id, message.sms, message.likes, message.time, category.cat_name')
				->from('message_sub')
				->join('message', 'message_sub.sms_id=message.id')
				->join('category', 'message_sub.cat_id=category.cat_id')
				->where('message_sub.cat_id', $id)
				->order_by('rand()')
				->limit($limit, $start_from)
				->get();
		return $query->result();
	}*/
	
	public function get_messages($id, $page) {
		$limit = 10;
		$start_from = ($page-1) * $limit;
		$query = $this->db->select('random_app_data')
				->from('category')
				->where('category.cat_id', $id)
				->get();
		$is_random = $query->row()->random_app_data;
		//print_r($query->result());
		//, message.sms, REPLACE(message.sms, 'a','b');, message.likes, message.time, category.cat_name');
		$this->db->select('message.id');
		$this->db->select("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(message.sms, '<br />','\n'), '<br/>','\n'), '<br>','\n'), '</br>','\n'), '</ br>','\n') AS 'sms'");
		$this->db->from('message_sub');
		$this->db->join('message', 'message_sub.sms_id=message.id');
		$this->db->join('category', 'message_sub.cat_id=category.cat_id');
		$this->db->where('message_sub.cat_id', $id);
		if($is_random=="0") {
			$this->db->order_by('message_sub.id','desc');
		} else {
			$this->db->order_by('rand()');
		}
		$this->db->order_by('rand()');
		$this->db->limit($limit, $start_from);
		$query = $this->db->get();
		return $query->result();
	}

	public function add_messages() {
		$this->db->set('sms','☹️ ');
		$query = $this->db->insert('message');
		return "yes";
	}
	
	public function like_message($sms_id) {
		$query = $this->db->select('likes')
				->from('message')
				->where('id', $sms_id)
				->get();
		$likes = $query->row_array()["likes"];
		$this->db->where('id', $sms_id);
		return $this->db->update("message", array('likes' => $likes+=1));
	}

}

?>