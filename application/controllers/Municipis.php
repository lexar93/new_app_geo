<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Municipis extends MY_Controller {

	
	//Controlador Principal 
	public function __construct()
	{
		parent::__construct();
		$this->data['body_class'] = '';	
	}

	public function index()
	{		
		redirect('/');
	}

	public function detall_municipi($idMunicipi=null)
	{		
		if(is_null($idMunicipi)){ redirect('/'); }
		$this->data['main_class'] = 'single-municipi cerca-detall';
		$this->data['id_municipi'] = $idMunicipi;
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/detall_municipi',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}
}
