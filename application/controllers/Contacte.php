<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacte extends MY_Controller {

	
	//Controlador Principal 
	public function __construct()
	{
		parent::__construct();
		$this->data['body_class'] = '';	
	}

	public function index()
	{		
		$this->data['main_class'] = 'contacto';
		$this->load->view($this->config->item('theme_path_frontend'). 'header', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'content/contacte',$this->data);
		$this->load->view($this->config->item('theme_path_frontend'). 'footer');
	}

	public function sendEmail(){
		$nom = $this->input->post('name');
		$cognoms = $this->input->post('surname');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$company = $this->input->post('company');
		$message = $this->input->post('message');

		$body = '
			Nom: ' . $nom . '<br />
			Cognoms:' . $cognoms . '<br />
			Email: ' . $email . '<br />
			Telf:' . $phone . '<br />
			Empresa:' . $company . '<br />
			Missatge: ' . $message . '<br />
		';
		
		$this->email->from('sender@wancora.cat', lang('email_contacte'));

	    $this->email->to('alex@wancora.cat');
	    $this->email->subject(lang('email_subject'));        
	    $this->email->message($body); 
	    $this->email->set_mailtype("html");
		
		
	    /*if($this->email->send()){  
			$data['result']= "true";
			$data['detail']= 'YEAH!';		
	    }else{
			$data['result']= "false";
			$data['detail']= 'NO YEAH!';		
		}*/
		$data['result']= "true";
		$data['detail']= 'YEAH!';		
		$this->load->view('json_view',  array('data'=>$data));	   
	}
}
