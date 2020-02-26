<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();	
		$this->data['body_class'] = '';			
	}

	public function index()
	{		
		$this->data['body_class'] = 'map-page';
		$this->data['main_class'] = 'maparea';
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/mapa',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

}
