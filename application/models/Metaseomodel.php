<?php

class MetaseoModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}

	public function getMetaseo($namepage){
		if(isset($namepage)){
			$this->load->database();
			$this->db->select('*');				
			$this->db->from('metaseo');				
			$this->db->where('namepage', $namepage);				
			$query = $this->db->get();
			if($query->num_rows() == 0){
				return null;
			}
			return($query->row());
		}	return null;
	}
	
}


?>