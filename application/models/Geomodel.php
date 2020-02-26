<?php

class GeoModel extends CI_Model{

	function __construct(){
		parent::__construct();
		
	}

	public function getCountries($id=null){
		$this->load->database();
		$this->db->select('*');					
		$this->db->from('countries');				
		if(isset($id)) $this->db->where('id', $id);
		$this->db->where('status', 1);	
		$this->db->order_by('country_name', 'asc');	
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getCountriesList($word=null){
		$this->load->database();
		$this->db->select('id, country_name');					
		$this->db->from('countries');		
		$this->db->where('status', 1);	
		if(isset($word)) $this->db->like('country_name', $word);	
		$this->db->order_by('country_name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getProvincesList($word=null){
		$this->load->database();
		$this->db->select('id, province');					
		$this->db->from('provinces');				
		if(isset($word)) $this->db->like('province', $word);
		$this->db->order_by('province', 'asc');		
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getProvinces($id=null){
		$this->load->database();
		$this->db->select('*');					
		$this->db->from('provinces');				
		if(isset($idprovincia)) $this->db->where('id', $id);		
		$this->db->order_by('province', 'asc');
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getCatLocations(){
		$this->load->database();
		$this->db->select('*');					
		$this->db->from('locations');				
		$this->db->where('idprovince', '7');
		$this->db->or_where('idprovince', '20');	
		$this->db->or_where('idprovince', '26');	
		$this->db->or_where('idprovince', '33');
		$this->db->order_by('location', 'asc');				
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	
	public function getLocationsByIDProvince($id=null){
		$this->load->database();
		$this->db->select('*');					
		$this->db->from('locations');				
		if(isset($id)) $this->db->where('idprovince', $id);		
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	
	
}

?>