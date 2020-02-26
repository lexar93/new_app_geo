<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends MY_Controller {

	
	//Controlador Perfil 
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) redirect(base_url($this->lang->lang().'/principal'), 'refresh'); 
		$user_id = $this->data['user']->id; 
		$this->data['profile'] = $this->profilemodel->getProfileByUserID($user_id);
		$this->data['body_class'] = '';	
	}

	public function index()
	{		
		$this->load->view($this->config->item('theme_path_frontend'). 'header');
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/mi_perfil',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

	public function mi_perfil()
	{		
		
		$this->load->view($this->config->item('theme_path_frontend'). 'header');
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/mi_perfil',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

}
