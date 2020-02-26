<?php

class SettingsModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}

	public function getSettings($nombre){
		if(isset($nombre)){
			$this->load->database();
			$this->db->select('*');				
			$this->db->from('settings');				
			$this->db->where('name', $nombre);				
			$query = $this->db->get();
			if($query->num_rows() == 0){
				return null;
			}
			return($query->result());
		}
		return null;
	}
	
}


?>