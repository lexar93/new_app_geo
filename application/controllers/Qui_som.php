<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qui_som extends MY_Controller {

	
	//Controlador Principal 
	public function __construct()
	{
		parent::__construct();
		$this->data['body_class'] = '';	
	}

	public function index()
	{		
		$this->load->view($this->config->item('theme_path_frontend'). 'header');
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/qui_som',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}
}
