<?php

class Auth_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function save_auth_key($data) {
		$this->db->insert('auth', $data);
		return $this->db->insert_id();
	}

	public function get_all_auth_key() {
		$this->db->select('*');
		$this->db->from('auth');
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	public function get_current_auth_key() {
		$this->db->select('auth_key');
		$this->db->from('auth');
		$this->db->order_by('rand()');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

}
