<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Back_dashboard extends CI_Controller {

	var $data;

	public function __construct(){
		parent::__construct();
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('admin'))
		{
			redirect(base_url('principal'), 'refresh');
		}
	}

	public function index(){		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'dashboard');
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}
}