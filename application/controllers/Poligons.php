<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poligons extends MY_Controller {

	
	//Controlador Principal 
	public function __construct()
	{
		parent::__construct();
		$this->data['body_class'] = '';	
	}

	public function index()
	{		
		$this->data['main_class'] = 'search-poligon search-page';
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/poligons',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

	public function detall_poligon($idPoligon=null)
	{		
		if(is_null($idPoligon)){ redirect('poligons/'); }
		$this->data['main_class'] = 'single-poligon cerca-detall';
		$this->data['id_poligon'] = $idPoligon;
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/detall_poligon',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}
}
