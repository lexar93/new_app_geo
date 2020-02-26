<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acces extends MY_Controller {
	
	//Controlador Acceso Usuarios
	public function __construct()
	{
		parent::__construct();
			
	}

	public function index()
	{		
		
		$this->load->view($this->config->item('theme_path_frontend'). 'header');
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/acces',$this->data);
	}
}
