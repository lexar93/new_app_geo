<?php

class PagesModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}


	public function getPage($id=null){
		if(isset($id)){
			$this->load->database();
			$this->db->select('*');			
			$this->db->from('pages');	
			$this->db->where('id', $id);	
			$this->db->where('status', 'active');
			$this->db->order_by("id", "asc"); 
			$query = $this->db->get();
			if($query->num_rows() == 0){
				return null;
			}
			return($query->row());
		}
		
	}

	public function getPageUrlSlug($url_slug=null){
		if(isset($url_slug)){
			$this->load->database();
			$this->db->select('*');			
			$this->db->from('pages');	
			$this->db->where('url_slug_'.$this->lang->lang(), $url_slug);	
			$this->db->where('status', 'active');
			$this->db->order_by("id", "asc"); 
			$query = $this->db->get();
			if($query->num_rows() == 0){
				return null;
			}
			return($query->row());
		}
		
	}

	public function getPages(){		
		$this->load->database();
		$this->db->select('*');			
		$this->db->from('pages');			
		$this->db->where('status', 'active');
		$this->db->order_by("id", "asc"); 
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());		
		
	}

	public function updatePage($id, $array_data){
		if(isset($id) and is_array($array_data)){
			$this->load->database();			
			$this->db->where('id', $id);
			return $this->db->update('pages',$array_data);
		}
		return false;
	}
		
	
}


?>