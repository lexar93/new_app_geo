<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends MY_Controller {
	
	//Controlador Principal 
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

	//Esta funcion carga la pagina escogida del footer
	public function pagina($url_slug=null){
		if(isset($url_slug)){
			//Se recupera la pagina con el id indicado y se carga la vista
			$this->data['pagina'] = $this->pagesmodel->getPageUrlSlug($url_slug);
			$this->load->view($this->config->item('theme_path_frontend'). 'header');
			$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
			$this->load->view($this->config->item('theme_path_frontend'). 'content/paginas',$this->data);
			$this->load->view($this->config->item('theme_path_frontend'). 'footer');			
		}			
	}

}
