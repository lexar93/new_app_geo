<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Back_crud extends CI_Controller {

	var $data;
	var $password;

	public function __construct(){
		parent::__construct();		
        $this->load->library('grocery_CRUD');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('admin'))
		{
			redirect(base_url('principal/'), 'refresh');
		}	
    }

	public function index(){
		if ($this->ion_auth->logged_in())
		{
			redirect(base_url('Back_dashboard/'), 'refresh');
		}		
	}

	public function encrypt_password($post_array, $primary_key = null){	  
	    $this->load->helper('security');
	    $this->password = $post_array['password'];	    
	    $post_array['password'] = $this->ion_auth->hash_password($post_array['password']);	    
	    return $post_array;
    }	

    public function activar_perfil_participante($post_array, $primary_key=null){    	    	    
	    if($post_array['active'] == '1'){
	    	$this->load->model('profilemodel');
	    	$profile = $this->profilemodel->getProfileByUserID($primary_key);
	    	if(isset($profile) and $profile->status == 'inactive'){
	    		$this->profilemodel->updateProfile($profile->id, array('status' => 'active'));
	    		//Una vez activado el perfil del usuario se manda un correo al mismo para informar que se ha activado la cuenta del usuario correspondiente
	    		$list = array($profile->email);
				
				$content=$this->load->view('emails/activacion_perfil', array('nombre' => $profile->name, 'apellidos' => $profile->surnames, 'telefono' => $profile->telephone, 'email'=> $profile->email), true);
		        $from_conf = $this->config->item('from');

		        if(isset($from_conf))$this->email->from($from_conf, 'Sant Feliu Maker League'); 
				else $this->email->from('sender@wancora.cat', 'Sant Feliu Maker League'); 			
				
				$this->email->to($list);
				$this->email->subject('Activació Perfil Participant Sant Feliu Maker League');        
		        $this->email->message($content); 
		        $this->email->set_mailtype("html");
		        
		        $this->email->send();
	    	}
	    }	    
	    return $post_array;
    }

    public function crear_perfil($post_array, $primary_key = null){	      	
	   	$this->load->model(array('profilemodel'));
	   	if(in_array("2", $post_array['groups']) || in_array("3", $post_array['groups'])){

	   		$data_user = array('created_on' => time());
			$this->ion_auth->update($primary_key, $data_user);

	   		$perfil = array();
	   		$perfil['iduser'] = $primary_key;
	   		$perfil['name'] = $post_array['username'];
	   		$perfil['surnames'] = $post_array['last_name'];
	   		$perfil['telephone'] = $post_array['phone'];
	   		$perfil['email'] = $post_array['email'];
	   		$perfil['status'] = 'active';
	   		$perfil['created_at'] = date('Y-m-d H:i:s');

	   		$existe = $this->profilemodel->getProfile($primary_key);
	   		if(!$existe) $this->profilemodel->insertProfile($perfil);	   		

	   		if(in_array("2", $post_array['groups']) and !$existe){	   			
	   			$content=$this->load->view('emails/activacion_perfil', array('nombre' => $post_array['username'], 'apellidos' => $post_array['last_name'], 'telefono' => $post_array['phone'], 'email'=> $post_array['email']), true);
		        $from_conf = $this->config->item('from');

		        if(isset($from_conf))$this->email->from($from_conf, 'Sant Feliu Maker League'); 
				else $this->email->from('sender@wancora.cat', 'Sant Feliu Maker League'); 			
				
				$list = array($post_array['email']);
				$this->email->to($list);
				$this->email->subject('Activació Perfil Participant Sant Feliu Maker League');        
		        $this->email->message($content); 
		        $this->email->set_mailtype("html");
		        
		        $this->email->send();
	   		}

	   	}   	
	    return $post_array;
    }

    public function generate_url_slug($post_array, $primary_key = null){	  
	    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
            
        $url_slug_ca = filter_var($post_array['title_ca'], FILTER_SANITIZE_STRING);        
        $url_slug_ca = strip_tags($url_slug_ca);    
        $url_slug_ca = stripslashes($url_slug_ca);        
        $url_slug_ca = strtr($url_slug_ca, $unwanted_array);   
        $titleURL_ca = strtolower(url_title($url_slug_ca));
        if(isUrlExists('news',$titleURL_ca)){
            $titleURL_ca = $titleURL_ca.'-'.time(); 
        }    
		$array_data = array();        
	    $array_data['url_slug_ca'] = $titleURL_ca;	     
	    $this->newsmodel->updateNew($primary_key, $array_data);   
	    return $post_array;
    }

    public function generate_url_slug_paginas($post_array, $primary_key = null){	  
	    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
            
        $url_slug_ca = filter_var($post_array['name_ca'], FILTER_SANITIZE_STRING);        
        $url_slug_ca = strip_tags($url_slug_ca);    
        $url_slug_ca = stripslashes($url_slug_ca);        
        $url_slug_ca = strtr($url_slug_ca, $unwanted_array);   
        $titleURL_ca = strtolower(url_title($url_slug_ca));            
		$array_data = array();        
	    $array_data['url_slug_ca'] = $titleURL_ca;	     
	    $this->pagesmodel->updatePage($primary_key, $array_data);   
	    return $post_array;
    }
    
	
	public function noticias(){
		$crud = new grocery_CRUD();		
		$crud->set_table('news');
		$crud->set_subject('Noticies');		
		$crud->columns('id', 'title_ca','excerpt_ca', 'image_featured', 'publication_date', 'status');
		$crud->required_fields('title_ca', 'excerpt_ca', 'content_ca', 'image_featured', 'title_seo_ca', 'description_seo_ca', 'keywords_seo_ca', 'publication_date');
		$crud->unset_fields(array('url_slug_ca', 'created_at', 'updated_at'));
		$ruta_imagen = 'uploads/news/images/';		
		if(!file_exists($ruta_imagen)){
			mkdir($ruta_imagen, 0777, true);
		}
		
		$crud->set_field_upload('image_featured', $ruta_imagen);
		$crud->set_field_upload('image_secondary', $ruta_imagen);			

		$crud->display_as('id','ID Noticia');			
		$crud->display_as('title_ca','Títol')->display_as('excerpt_ca','Resum');
		$crud->display_as('content_ca','Contingut')->display_as('image_featured','Imatge Destacada');
		$crud->display_as('status','Estat')->display_as('image_secondary','Imatge Secundaria');
		
		$crud->set_relation_n_n('categories', 'news_categories', 'categories', 'idnew','idcategory', 'name_ca');
		$crud->display_as('categories','Categories')->display_as('publication_date','Data de publicació');

		$crud->display_as('title_seo_ca','Títol SEO')->display_as('description_seo_ca','Descripció SEO')->display_as('keywords_seo_ca','Keywords SEO');
		
		$crud->callback_after_insert(array($this,'generate_url_slug'));
		$crud->callback_after_update(array($this,'generate_url_slug'));

		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('id','desc');
		
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function categorias(){
		$crud = new grocery_CRUD();	
		$crud->set_table('categories');
		$crud->set_subject('Categories');		
		$crud->columns('id','name_ca');
		$crud->unset_fields(array('created_at', 'updated_at'));
		$crud->required_fields('name_ca');

		$crud->display_as('id','Categoria');
		$crud->display_as('name_ca','Nom');
				
		$crud->unset_export();
		$crud->unset_print();
		
		$crud->order_by('id','asc');

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function usuarios(){
		$crud = new grocery_CRUD();
		$crud->set_table('users');
		$crud->set_subject('Usuaris');
		$crud->columns('email', 'first_name', 'last_name', 'phone', 'groups', 'active');				
		$crud->unset_fields(array('salt', 'ip_address', 'activation_code', 'forgotten_password_code', 'forgotten_password_time', 'remember_code', 'created_on', 'last_login', 'company'));
		$crud->unset_edit_fields('salt', 'ip_address', 'activation_code','password', 'forgotten_password_code', 'forgotten_password_time', 'remember_code', 'created_on', 'last_login', 'company');
		$crud->change_field_type('password','password');
		$crud->required_fields('email','username','first_name','last_name','active','password');
		
		$crud->unique_fields(['email']);		
		
		$crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id','group_id', 'name');			
				
		$state = $crud->getState();

		if($state == 'list')
		{		    
		    $crud->display_as('groups','Grup');
		}

		if($state == 'edit')
		{		    
		    $crud->display_as('groups','Grup (Escollir només un)');
		}

		if($state == 'add')
		{		    
		    $crud->display_as('groups','Grup (Escollir només un)');
		}

		$crud->display_as('username','Usuari');
		$crud->display_as('first_name','Nom');
		$crud->display_as('last_name','Cognoms');	
		$crud->display_as('phone','Telèfon');			
		$crud->display_as('active','Estat');			
		 
		$crud->set_lang_string('delete_error_message', 'No pots eliminarte a tu mateix com a usuari conectat');
		$crud->callback_before_insert(array($this,'encrypt_password'));
		$crud->callback_before_update(array($this,'activar_perfil_participante'));
		$crud->callback_after_insert(array($this,'crear_perfil'));
		$crud->callback_before_delete(array($this,'clear_all_user_dependencies'));
		
		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('id','desc');	
		
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function clear_all_user_dependencies($primary_key = null){	  	    
	    $user = $this->ion_auth->user()->row();
	    if($primary_key == $user->id){	  	
	    	return FALSE;
	    } 	    
	    return TRUE;
    }

	public function perfiles(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('profile');
		$crud->set_subject('Perfils');				

		$state = $crud->getState();
		$state_info = $crud->getStateInfo();
		if($state == 'export')
		{				
			$crud->columns('name', 'surnames', 'email', 'telephone', 'dni', 'age', 'location', 'twitter', 'linkedin', 'repte', 'laboralstate', 'empresa', 'work_technology', 'reasons', 'created_at');				    		    			
		}
		else{
			$crud->columns('name', 'surnames', 'email', 'telephone', 'dni', 'age', 'location', 'laboralstate', 'project_file', 'created_at');
		}	

		$ruta_archivos = 'uploads/profiles/';		
		if(!file_exists($ruta_archivos)){
			mkdir($ruta_archivos, 0777, true);
		}

		$crud->set_field_upload('image', $ruta_archivos);

		$ruta_archivos = 'uploads/projectfiles/';		
		if(!file_exists($ruta_archivos)){
			mkdir($ruta_archivos, 0777, true);
		}
		$crud->set_field_upload('project_file', $ruta_archivos);

		$crud->unset_fields(array('created_at', 'updated_at'));		

		$crud->unset_texteditor(array('work_technology'));	

		$crud->set_relation('location', 'locations', 'location');
		$crud->set_relation('idchallenge', 'challenge', 'title_ca');
		$crud->set_relation('idteam', 'team', 'name');

		$crud->field_type('iduser','readonly');
		$crud->field_type('email','readonly');
		$crud->field_type('laboralstate','dropdown', array( "autonom"  => lang('autonomo'), "treballador_alie" => lang('trabajador_ajeno'), "jubilat" => lang('jubilado'), "estudiant" => lang('estudiante'), "aturat" => lang('parado')));
		//$crud->field_type('work_technology','multiselect', array( "microcontrollers"  => "Microcontoladores", "fabricacion_digital" => "Fabricación Digital", "sensorica" => "Sensórica", "wereable" => "Wereable", "realitat_virtual" => "Realidad Virtual", "software_lliure" => "Software Libre", "drones" => "Drones"));

		$crud->display_as('iduser','ID Usuari');

		$crud->display_as('idchallenge','Repte Assignat');
		$crud->display_as('idteam','Equip');
		$crud->display_as('name','Nom');
		$crud->display_as('surnames','Cognoms');
		$crud->display_as('email','Email');	
		$crud->display_as('telephone','Telèfon');
		$crud->display_as('dni','DNI');				
		$crud->display_as('age','Any Naixament');	
		$crud->display_as('location','Població');
		$crud->display_as('profession','Profesió');
		$crud->display_as('laboralstate','Estat Laboral');
		$crud->display_as('empresa','Empresa');
		$crud->display_as('work_technology','Tecnologies Treballades');	
		$crud->display_as('reasons','Motius de participació en la SFML');
		$crud->display_as('repte','Repte Triat');
		$crud->display_as('image','Imatge Perfil');
		$crud->display_as('project_file','Arxiu Projectes');
		$crud->display_as('created_at','Creat el');					
		$crud->display_as('updated_at','Modificat el');	
		$crud->display_as('status','Estat');			
		 		
		$crud->unset_add();
		//$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_print();
				
		$crud->order_by('id','desc');	
		
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}
	

	public function equipos(){
		$crud = new grocery_CRUD();	
		$crud->set_table('team');
		$crud->set_subject('Equips');		
		$crud->columns('name', 'description_ca', 'idchallenge', 'status');
		$crud->unset_fields(array('created_at', 'updated_at'));
		$crud->required_fields('idchallenge', 'name');
				
		$crud->display_as('idchallenge','Repte Inscrit')->display_as('name','Nom');
		$crud->display_as('description_ca','Descripció')->display_as('status','Estat');
		$crud->display_as('created_at','Creado el')->display_as('updated_at','Modificat el');

		$crud->set_relation('idchallenge', 'challenge', 'title_ca');
				
		//$crud->unset_add();
		//$crud->unset_delete();
		$crud->unset_print();
		$crud->unset_export();

		//$crud->add_action('Ver Participantes', '', 'Back_crud/ver','fa fa-file');
		
		$crud->order_by('id','asc');

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}	

	public function retos(){
		$crud = new grocery_CRUD();	
		$crud->set_table('challenge');
		$crud->set_subject('Reptes');		
		$crud->columns('title_ca','description_ca', 'num_participants', 'status');
		$crud->unset_fields(array('created_at', 'updated_at'));
		$crud->required_fields('title_ca', 'num_participants');
				
		$crud->display_as('title_ca','Títol')->display_as('description_ca','Descripció');
		$crud->display_as('num_participants','Número Máxim Participants')->display_as('status','Estat');
		$crud->display_as('created_at','Creat el')->display_as('updated_at','Modificat el');
				
		
		$crud->unset_print();
		$crud->unset_export();
		
		$crud->order_by('id','asc');

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}	
		
	public function eventos(){
		$crud = new grocery_CRUD();	
		$crud->set_table('event');
		$crud->set_subject('Esdeveniments');		
		$crud->columns('title', 'speaker', 'date_inscription', 'date_event', 'horari', 'location', 'restrict_public', 'max_inscriptions', 'status', 'image');
		$crud->unset_fields(array('created_at', 'updated_at'));
		$crud->required_fields('title', 'image', 'hour', 'location');


		$crud->unset_texteditor(array('url_geolocation'));
		$ruta_archivos = 'uploads/eventos/';		
		if(!file_exists($ruta_archivos)){
			mkdir($ruta_archivos, 0777, true);
		}

		$crud->set_field_upload('image', $ruta_archivos);

		$crud->display_as('title','Títol')->display_as('restrict_public','Restricció Públic')->display_as('date_inscription','Data de Inscripció')->display_as('date_event','Data del Esdeveniment');
		$crud->display_as('speaker','Formadors')->display_as('horari','Horari')->display_as('status','Estat')->display_as('image','Imatge');
		$crud->display_as('location','Localització')->display_as('created_at','Creat el')->display_as('updated_at','Modificat el')->display_as('max_inscriptions','Màxim de inscrits');
				
		$crud->add_action('Registrats', '', 'Back_crud/esdeveniment_usuaris_registrats','fa fa-check');

		$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->order_by('id','asc');

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}	

	public function esdeveniment_usuaris_registrats($idevent){
		$crud = new grocery_CRUD();	
		$crud->set_table('event_register');
		$crud->set_subject('Registrats al Esdeveniment');		
		
	    $crud->columns('idevent', 'name', 'surnames', 'dni', 'email', 'telephone', 'location', 'created_at');
	    				
		$crud->display_as('idevent','Esdeveniment');	
		$crud->display_as('name','Nom');		
		$crud->display_as('surnames','Cognoms');		
		$crud->display_as('dni','DNI');		
		$crud->display_as('email','Email');		
		$crud->display_as('telephone','Telèfon');		
		$crud->display_as('location','Localització');			
		$crud->display_as('created_at','Registrat el');
		
		$crud->set_relation('idevent', 'event', 'title');
		$crud->set_relation('location', 'locations', 'location');		
						
		//$crud->unset_add();
		$crud->unset_edit();
		//$crud->unset_delete();		
		//$crud->unset_export();
		$crud->unset_print();		

		$crud->where('idevent', $idevent);
		
		$crud->order_by('id','asc');

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav', $this->data);
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function paises(){
		$crud = new grocery_CRUD();	
			
		$crud->set_table('countries');
		$crud->set_subject('Països');
		
		$crud->columns('country_code', 'country_name', 'code_taxname', 'percent_tax', 'status');	
		$crud->unset_fields(array('updated_at'));			
				
		$crud->display_as('country_code', 'Codi de País');
		$crud->display_as('country_name', 'Nom');
		$crud->display_as('code_taxname', 'Codi de Impost');
		$crud->display_as('percent_tax', 'Valor de Impost (%)');
		$crud->display_as('ue', 'Unió europea');
		$crud->display_as('status', 'Estat');		
				
		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('id','desc');
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}


	public function contact(){
		$crud = new grocery_CRUD();	
			
		$crud->set_table('contact');
		$crud->set_subject('Contacte');
		
		$crud->columns('address', 'postal_code', 'location', 'city', 'email', 'telephone1');		
		$crud->unique_fields(array('email'));		
		$crud->required_fields(array('address', 'postal_code', 'location', 'city', 'email', 'telephone1', 'lat', 'long'));
				
		$crud->display_as('address','Adreça');
		$crud->display_as('postal_code','Códi Postal');		
		$crud->display_as('location','Població');
		$crud->display_as('city','Ciutat');		
		$crud->display_as('email','Email');
		$crud->display_as('telephone1','Telèfon Movil');
		$crud->display_as('telephone2','Telèfon Alternatiu');			
		$crud->display_as('lat','Latitud');
		$crud->display_as('lon','Longitud');
		
		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('id','desc');
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function paginas(){
		$crud = new grocery_CRUD();	
			
		$crud->set_table('pages');
		$crud->set_subject('Pàgines');		
		
		$crud->columns('name_ca', 'url_slug_ca', 'content_ca', 'status');	
		$crud->unset_fields(array('url_slug_ca', 'created_at', 'updated_at'));		

		$crud->display_as('name_ca','Nom');	
		$crud->display_as('url_slug_ca','URL Amigable');			
		$crud->display_as('content_ca','Contingut');			
		$crud->display_as('status','Estat');		

		$crud->callback_after_insert(array($this,'generate_url_slug_paginas'));
		$crud->callback_after_update(array($this,'generate_url_slug_paginas'));
		
		$crud->unset_export();
		$crud->unset_print();		
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function metaseo(){
		$crud = new grocery_CRUD();	
			
		$crud->set_table('metaseo');
		$crud->set_subject('SEO');
		//$crud->unset_add();
		$crud->unset_delete();
		$crud->columns('namepage', 'title_ca', 'description_ca', 'keys_ca');		
		$crud->unique_fields(array('namepage'));		
		$crud->required_fields(array('namepage'));

		//$crud->set_rules('namepage', 'namepage', 'required|is_unique');
		$crud->set_lang_string('update_error', 'El nom de la pàgina no pot estar buit i ha de ser únic');
		$crud->display_as('namepage','Nom');
		$crud->display_as('title_ca','Títol');
		$crud->display_as('description_ca','Descripció');		
		$crud->display_as('keys_ca','Paraules Clau');	

		$crud->set_lang_string('required', 'El nom de la pàgina no pot estar buit');
		
		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('id','desc');
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	public function media(){
		$crud = new grocery_CRUD();
		$crud->set_table('media');
		$crud->set_subject('Media');
		$crud->field_type('url','readonly');
		$crud->columns('img','url', 'date');
		$crud->required_fields('img');
		$crud->unset_export();
		$crud->unset_print();
		$ruta = 'uploads/media/';
		if(!file_exists($ruta)){
			mkdir($ruta, 0777, true);
		}
		$crud->set_field_upload('img', $ruta);
		$crud->order_by('id','desc');
		
		$crud->callback_after_insert(array($this, 'generar_urls_media'));
		$crud->callback_after_update(array($this, 'generar_urls_media'));

		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
	}

	public function generar_urls_media($post_array,$primary_key){ 
		$img = filter_var($post_array['img'], FILTER_SANITIZE_STRING); 
		$url = base_url('uploads/media/' . $img);
		
		$dades = array(
			"id" => $primary_key,
			"url" => $url
		);
		$this->db->update('media',$dades,array('id' => $primary_key));
		return true;
	}
	
	public function settings(){
		$crud = new grocery_CRUD();	
			
		$crud->set_table('settings');
		$crud->set_subject('Settings');
		
		$crud->columns('name', 'description', 'value');				
		$crud->change_field_type('value','integer');
		$crud->unset_texteditor('name','varchar');
		$crud->unset_texteditor('value','text');
		$crud->display_as('name','Nom');
		$crud->display_as('description','Descripció');		
		$crud->display_as('value','Valor');
		
		$crud->unset_export();
		$crud->unset_print();
		$crud->order_by('name','desc');
		$output = $crud->render();
		
		$this->load->view($this->config->item('theme_path_backend'). 'header');
		$this->load->view($this->config->item('theme_path_backend'). 'nav');
		$this->load->view($this->config->item('theme_path_backend'). 'topnav');
		$this->load->view($this->config->item('theme_path_backend'). 'crud', $output);
		$this->load->view($this->config->item('theme_path_backend'). 'footer');
	}

	
	
}