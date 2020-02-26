<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	var $data;
	 
	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		if ($this->ion_auth->logged_in())
		{
			if(!$this->ion_auth->is_admin()){
				$this->data['user'] = $this->ion_auth->user()->row();
				$this->data['profile'] = $this->profilemodel->getProfileByUserID($this->data['user']->id);
			}
										
		}

		//$this->lang->load('global','catalan');

		// Carga del SEO
		$this->data['title'] = lang('seo_title_default');
		$this->data['description'] = lang('seo_desc_default');
		$this->data['keys'] = lang('seo_keys_default');

		if($this->router->fetch_method() != '' && $this->router->fetch_method() != 'index')
			$seo = $this->metaseomodel->getMetaseo($this->router->fetch_method());
		else
			$seo = $this->metaseomodel->getMetaseo($this->router->fetch_class());
	
		if(isset($seo)){
			$title = 'title_'.$this->lang->lang();
			$description = 'description_'.$this->lang->lang();
			$keys = 'keys_'.$this->lang->lang();

			$this->data['title'] = $seo->$title;
			$this->data['description'] = $seo->$description;
			$this->data['keys'] = $seo->$keys;

		}

		//Carga de las páginas del footer
		$this->data['pages'] = $this->pagesmodel->getPages();
		$this->data['contact'] = $this->contactmodel->getContact();
			
	}
	
}