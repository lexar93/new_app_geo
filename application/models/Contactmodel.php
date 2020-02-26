<?php

class ContactModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}

	public function getContact(){		
		$this->load->database();
		$this->db->select('*');				
		$this->db->from('contact');	
		$this->db->limit(1);		
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->row());
	}
	
}


?>