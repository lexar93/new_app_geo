<?php

class NewsModel extends CI_Model{


	function __construct(){
		parent::__construct();
		
	}

	public function getTotalNews() 
    {
    	$this->load->database();   
    	$this->db->where('status', 'active');	 
        return $this->db->count_all_results('news');
    }

	public function getNews($id=null, $orderby=null, $limit=null, $start=null){
		$this->load->database();
		$this->db->select('*');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d/%m/%Y\') AS publication_date_format');				
		$this->db->from('news');	
		$this->db->where('title_'.$this->lang->lang().' !=', null);
		$this->db->where('title_'.$this->lang->lang().' !=', "");	
		$this->db->where('content_'.$this->lang->lang().' !=', null);
		$this->db->where('content_'.$this->lang->lang().' !=', "");	
		$this->db->where('status', 'active');	
		$currentdate = date('Y-m-d H:i:s');
		$this->db->where('(publication_date <= "'.$currentdate.'")', null, false);		
		if(isset($id)) $this->db->where('id', $id);	
		if(isset($limit) and isset($start)) $this->db->limit($limit, $start);
		if(isset($orderby)) $this->db->order_by($orderby, "desc");
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getBackNew($id=null){
		$this->load->database();
		$this->db->select('*');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d %M %Y\') AS publication_date_format');
		$this->db->select('DATE_FORMAT(publication_date, \'%d\') AS fp_day');		
		$this->db->select('DATE_FORMAT(publication_date, \'%M\') AS fp_month');
		$this->db->select('DATE_FORMAT(publication_date, \'%Y\') AS fp_year');		
		$this->db->from('news');
		$this->db->where('title_'.$this->lang->lang().' !=', null);
		$this->db->where('title_'.$this->lang->lang().' !=', "");	
		$this->db->where('content_'.$this->lang->lang().' !=', null);
		$this->db->where('content_'.$this->lang->lang().' !=', "");
		$this->db->where('status', 'active');
		$this->db->where('id <', $id);
		$currentdate = date('Y-m-d H:i:s');
		$this->db->where('(publication_date <= "'.$currentdate.'")', null, false);		
		$this->db->limit(1);
		$this->db->order_by('id', "desc");					
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->row());
	}

	public function getForwardNew($id=null){
		$this->load->database();
		$this->db->select('*');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d %M %Y\') AS publication_date_format');
		$this->db->select('DATE_FORMAT(publication_date, \'%d\') AS fp_day');		
		$this->db->select('DATE_FORMAT(publication_date, \'%M\') AS fp_month');
		$this->db->select('DATE_FORMAT(publication_date, \'%Y\') AS fp_year');		
		$this->db->from('news');
		$this->db->where('title_'.$this->lang->lang().' !=', null);
		$this->db->where('title_'.$this->lang->lang().' !=', "");	
		$this->db->where('content_'.$this->lang->lang().' !=', null);
		$this->db->where('content_'.$this->lang->lang().' !=', "");
		$this->db->where('status', 'active');
		$this->db->where('id >', $id);
		$currentdate = date('Y-m-d H:i:s');
		$this->db->where('(publication_date <= "'.$currentdate.'")', null, false);		
		$this->db->limit(1);	
		$this->db->order_by('id', "asc");				
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->row());
	}

	public function getFeaturedNew(){
		$this->load->database();
		$this->db->select('*');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d-%m-%Y\') AS publication_date_format');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d\') AS fp_day');		
		$this->db->select('DATE_FORMAT(publication_date, \'%M\') AS fp_month');
		$this->db->select('DATE_FORMAT(publication_date, \'%Y\') AS fp_year');			
		$this->db->from('news');
		$this->db->where('title_'.$this->lang->lang().' !=', null);
		$this->db->where('title_'.$this->lang->lang().' !=', "");	
		$this->db->where('content_'.$this->lang->lang().' !=', null);
		$this->db->where('content_'.$this->lang->lang().' !=', "");
		$this->db->where('status', 'active');
		$currentdate = date('Y-m-d H:i:s');
		$this->db->where('(publication_date <= "'.$currentdate.'")', null, false);		
		$this->db->limit(1);
		$this->db->order_by('publication_date', "desc");			
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}

	public function getNewsByUrlSlug($urlslug){
		$this->load->database();
		$this->db->select('*');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d-%m-%Y\') AS publication_date_format');	
		$this->db->select('DATE_FORMAT(publication_date, \'%d\') AS fp_day');		
		$this->db->select('DATE_FORMAT(publication_date, \'%M\') AS fp_month');
		$this->db->select('DATE_FORMAT(publication_date, \'%Y\') AS fp_year');			
		$this->db->from('news');	
		$this->db->where('status', 'active');		
		$currentdate = date('Y-m-d H:i:s');
		$this->db->where('(publication_date <= "'.$currentdate.'")', null, false);				
		if(isset($urlslug)) {
			$this->db->where('url_slug_ca', $urlslug);			
			$this->db->where('title_'.$this->lang->lang().' !=', null);
			$this->db->where('title_'.$this->lang->lang().' !=', "");	
			$this->db->where('content_'.$this->lang->lang().' !=', null);
			$this->db->where('content_'.$this->lang->lang().' !=', "");				
		}	
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}


	public function getCategoriesByIDNew($id){
		$this->load->database();
		$this->db->select('c.*');					
		$this->db->from('news_categories nc');
		$this->db->join('categories c', 'c.id = nc.idcategory');			
		$this->db->where('nc.idnew', $id);	
		$query = $this->db->get();
		if($query->num_rows() == 0){
			return null;
		}
		return($query->result());
	}


	public function insertNoticia($array_data){
		if(is_array($array_data)){
			$this->load->database();		
			$this->db->insert('news', $array_data);
			return $this->db->insert_id();
		}
		return false;
	}
		
	public function updateNew($id, $array_data){
		if(isset($id) and is_array($array_data)){
			$this->load->database();			
			$this->db->where('id', $id);
			return $this->db->update('news',$array_data);
		}
		return false;
	}

	public function deleteNew($id){
		if(isset($id)){
			$this->load->database();
			$this->db->where('id', $id);
			return $this->db->delete('news');
		}
		return false;
	}

	
	
}


?>