<?php

class ProfileModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}

	public function getProfile($id=null){
		$this->load->database();
		$this->db->select('*');							
		$this->db->from('profile');			
		//$this->db->where('status', 'active');			
		if(isset($id)) $this->db->where('id', $id);			
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	
	public function getProfileByUserID($iduser=null){
		$this->load->database();
		$this->db->select('*');							
		$this->db->from('profile');			
		//$this->db->where('status', 'active');			
		if(isset($iduser)) $this->db->where('iduser', $iduser);			
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->row());
	}

	public function getParticipantByEmail($email=null){
		$this->load->database();
		$this->db->select('us.*');					
		$this->db->from('users us');
		$this->db->join('users_groups ug', 'ug.user_id = us.id');
		$this->db->join('groups gr', 'gr.id = ug.group_id');	
		$this->db->where('gr.name', 'makers');		
		$this->db->where('us.email', $email);		
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->row());
	}

	public function getAdmins(){
		$this->load->database();
		$this->db->select('us.*');					
		$this->db->from('users us');
		$this->db->join('users_groups ug', 'ug.user_id = us.id');
		$this->db->join('groups gr', 'gr.id = ug.group_id');	
		$this->db->where('gr.name', 'admin');		
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function insertProfile($array_data){
		if(is_array($array_data)){
			$this->load->database();		
			$this->db->insert('profile', $array_data);
			return $this->db->insert_id();
		}
		return false;
	}
		
	public function updateProfile($id, $array_data){
		if(isset($id) and is_array($array_data)){
			$this->load->database();			
			$this->db->where('id', $id);
			return $this->db->update('profile', $array_data);
		}
		return false;
	}

	public function deleteProfile($id){
		if(isset($id)){
			$this->load->database();
			$this->db->where('id', $id);
			return $this->db->delete('profile');
		}
		return false;
	}

	
	
}


?>