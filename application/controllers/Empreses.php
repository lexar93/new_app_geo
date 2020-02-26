<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empreses extends MY_Controller {
	
	//Controlador Principal 
	public function __construct()
	{
		parent::__construct();
		$this->data['body_class'] = '';		
	}

	public function index()
	{		
		$this->data['main_class'] = 'search-activitat search-page';
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/empreses',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

	public function detall_empresa($idEmpresa=null)
	{		
		if(is_null($idEmpresa)){ redirect('empreses/'); }
		$this->data['main_class'] = 'single-activitat cerca-detall';
		$this->data['id_empresa'] = $idEmpresa;
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/detall_empresa',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}
}
