<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	var $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();				
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
	}

	
	// log the user in
	public function login()
	{
		$data = array();
		$data['title'] = $this->lang->line('login_heading');

		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$data['detail'] = $this->ion_auth->messages();
				if($this->ion_auth->is_admin()) $type = 'admin'; else $type = 'other';
				$data['type'] = $type;
				$data['result'] = "true";				
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$data['detail'] = $this->ion_auth->errors();
				$data['result'] = "error";
				
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$data['detail'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);
			$data['result'] = "error";

		}
		$this->load->view('json_view',  array('data'=>$data));
	}
	

	// log the user out
	public function logout()
	{
		$data = array();
		$data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		$data['result']="true";
		$this->load->view('json_view',  array('data'=>$data));
	}

	public function registrarParticipante()
    {
        $data = array();
		$data['title'] = lang('Register')." Sant Feliu Maker League";
               
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        
        // validate form input        
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('username',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }

        if ($this->form_validation->run() == true)
        {
        	$email    = strtolower($this->input->post('identity'));	        
	        $username = $this->input->post('username');  
	        $surnames = $this->input->post('surnames');    
	        
	        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		    $pass = array(); //remember to declare $pass as an array
		    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		    for ($i = 0; $i < 8; $i++) {
		        $n = rand(0, $alphaLength);
		        $pass[] = $alphabet[$n];
		    }
		    $password = implode($pass); //turn the array into a string      
	       	
	        $additional_data = array('first_name' => $username, 'last_name' => $surnames, 'phone' => $this->input->post('telephone'), 'active' => '0');
	        $group = array('2');
        	$user_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group);
        	if($user_id)
	        {
	        	$data['result'] = "true";
	            $data['detail'] =  $this->ion_auth->messages();	

				$perfil = array();
				$perfil['iduser'] = $user_id;		
				$perfil['name'] = $this->input->post('username');
				$perfil['surnames'] = $this->input->post('surnames');
				$perfil['email'] = $this->input->post('identity');
				$perfil['telephone'] = $this->input->post('telephone');
				$perfil['dni'] = $this->input->post('dni');
				$perfil['location'] = $this->input->post('town');	
				$perfil['repte'] = $this->input->post('repte');					
				$perfil['twitter'] = $this->input->post('twitter');
				$perfil['linkedin'] = $this->input->post('linkedin');				
				$perfil['laboralstate'] = $this->input->post('laboralstate');
				$perfil['empresa'] = $this->input->post('empresa');
				$perfil['age'] = $this->input->post('age');
				$work_technology = $this->input->post('tecnologies');
				$restech = "";
				$numItems = count($work_technology);
				$i = 0;
				foreach ($work_technology as $technology) {
					++$i;
					if($i === $numItems) {
						$restech .= $technology;
					}
					else{
						$restech .= $technology.',';
					}
				}
				$perfil['work_technology'] = $restech;
				$perfil['reasons'] = $this->input->post('motivos');

				$newsletter = $this->input->post('newsletter_aigues');			
				if(!isset($newsletter) || (isset($newsletter) and ($newsletter == false || $newsletter == 'No'))) $perfil['newsletter'] = 'No';  
				else $perfil['newsletter'] = 'Si';
							
		       	$perfil['created_at'] = date('Y-m-d H:i:s');
				
		       	$ruta = "uploads/projectfiles/";
				if(!file_exists($ruta)){
					mkdir($ruta, 0777, true);
				}

				foreach($_FILES as $key){	           
		            if($key['error'] == UPLOAD_ERR_OK ){	            	
					    $originalFileName = $key['name'];
					     //Se obtiene la posicion del punto del fichero
						$positionOfDot =  strripos($originalFileName, ".");
						///Se obtiene el formato de la imagen
						$formatOfFile = strtolower(substr($originalFileName,$positionOfDot));
						//$mimeformatfile = $_FILES['file-upload']['type'];				
						//$mimeformatfile = ".".substr($mimeformatfile, 6);				
					    $nombre = "projectfile_".uniqid();
					    $nombreext = $nombre.$formatOfFile;
					    $temporal = $key['tmp_name'];
					    $nombre = preg_replace('/\s+/', '', $nombreext);
					    $uploadfile = $ruta.$nombreext;	
						move_uploaded_file($temporal, $uploadfile);
						chmod($uploadfile, 0777);		

						$perfil['project_file'] = $nombre;
					}
				}
				
				$this->profilemodel->insertProfile($perfil);
				$list = array();
				//Enviar mail al participante y los administradores para notificar que se ha inscrito correctamente	
				$admins = $this->profilemodel->getAdmins();
				if(isset($admins)){
					foreach ($admins as $admin) {
						array_push($list, $admin->email);						
					}	
				}
				
				$content=$this->load->view('emails/registre_participant', array('nombre' => $perfil['name'], 'apellidos' => $perfil['surnames'], 'telefono' => $perfil['telephone'], 'email'=> $perfil['email']), true);
		        $from_conf = $this->config->item('from');

		        if(isset($from_conf))$this->email->from($from_conf, 'Sant Feliu Maker League'); 
				else $this->email->from('sender@wancora.cat', 'Sant Feliu Maker League'); 			
				
				$this->email->to($email);				
				$this->email->bcc($list);
				$this->email->subject(lang('Register participant'));        
		        $this->email->message($content); 
		        $this->email->set_mailtype("html");
		        
		        if($this->email->send()){        	
		        	$data['result']= "true";
					$data['detail']= lang('Register participant info short');
		        }
		        else{
		        	$data['result']= "error";
					$data['detail']= $this->email->print_debugger();
		        }			
				

	        }
	        else
	        {            
	            $data['result'] = "error2";
	            $data['detail'] = $this->ion_auth->errors();
	        }
        }
        else
        {            
            $data['result'] = "error3";
            $data['detail'] = lang('Register duplicated');
        }
        $this->load->view('json_view',  array('data'=>$data));
        
    }

    public function registrarMiembro()
    {
        $data = array();
		$data['title'] = lang('Register')."Sant Feliu Maker League";
               
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        
        // validate form input        
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('username',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }

        if ($this->form_validation->run() == true)
        {
        	$identity    = strtolower($this->input->post('identity'));	        
	        $username = $this->input->post('username');  
	        $password = $this->input->post('password');
	        $activation_code = sha1(md5(microtime()));          
	        	            	       	
	        $additional_data = array('first_name' => $username, 'activation_code' => $activation_code, 'active' => '0');
	        $group = array('4');
        	$user_id = $this->ion_auth->register($username, $password, $identity, $additional_data, $group);
        	if($user_id)
	        {
	        	$data['result'] = "true";
	            $data['detail'] =  $this->ion_auth->messages();	
					
				$list = array($identity);
			
				$content=$this->load->view('emails/activate', array('identity' => $identity, 'id' => $user_id, 'activation' => $activation_code), true);
		        $from_conf = $this->config->item('from');

		        if(isset($from_conf))$this->email->from($from_conf, 'Aigües BCN'); 
				else $this->email->from('sender@wancora.cat', 'Aigües BCN'); 			
				
				$this->email->to($list);
				$this->email->subject('Activación Cuenta Miembro Aigües BCN');        
		        $this->email->message($content); 
		        $this->email->set_mailtype("html");
		        
		        if($this->email->send()){        	
		        	$data['result']= "true";
		        	$data['title'] = lang('Register member');
					$data['detail']= lang('Register member info');
		        }
		        else{
		        	$data['result']= "error";
					$data['detail']= $this->email->print_debugger();
		        }

	        }
	        else
	        {            
	            $data['result'] = "error2";
	            $data['detail'] = $this->ion_auth->errors();
	        }
        }
        else
        {            
            $data['result'] = "error3";
            $data['detail'] = lang('account_creation_duplicate_email');
        }
        $this->load->view('json_view',  array('data'=>$data));
        
    }

	

	// change password
	public function change_password()
	{
		$data = array();
		$data['title'] = lang('Change Password');

		$this->form_validation->set_rules('currentpassword', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('newpassword', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[repnewpassword]');
		$this->form_validation->set_rules('repnewpassword', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			$data['result'] = "error";
			$data['detail'] = lang('Need Login');
		}
		else{

			$user = $this->ion_auth->user()->row();
			if ($this->form_validation->run() == false)
			{
				// display the form
				// set the flash data error message if there is one
				$data['detail'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				
			}
			else
			{
				$identity = $this->session->userdata('identity');
				$change = $this->ion_auth->change_password($identity, $this->input->post('currentpassword'), $this->input->post('newpassword'));

				if ($change)
				{
					//if the password was successfully changed
					$data['result'] = "true";
					$data['detail'] = lang('New password confirmed');
				}
				else
				{	
					$data['result'] = "error";
					$data['detail'] = $this->ion_auth->errors();
					
				}
			}
			$this->load->view('json_view',  array('data'=>$data));
		}
	}

	// forgot password
	public function forgot_password()
	{

		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') !== 'email' )
		{
		   $this->form_validation->set_rules('user-email', $this->lang->line('forgot_password_identity_label'), 'valid_email');		   
		}
		else
		{
		   $this->form_validation->set_rules('user-email', $this->lang->line('forgot_password_validation_email_label'), 'valid_email');
		}


		if ($this->form_validation->run() == true)		
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('user-email'))->users()->row();

			if(empty($identity)) {

        		if($this->config->item('identity', 'ion_auth') != 'email')
            	{
            		$this->ion_auth->set_error('forgot_password_identity_not_found');
            	}
            	else
            	{
            	   $this->ion_auth->set_error('forgot_password_email_not_found');
            	}

               	$data['detail'] = $this->ion_auth->errors();
               	$data['result'] = "error";
        		
    		}
    		else{
    			// run the forgotten password method to email an activation code to the user
				$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

				if ($forgotten)
				{					
					$data['detail'] = $this->ion_auth->messages();
               		$data['result'] = "true";
				}
				else
				{					
					$data['detail'] = $this->ion_auth->errors();
               		$data['result'] = "error";
				}
    		}
			
		}
		else
		{
			// if the login was un-successful
			// redirect them back to the login page
			$data['detail'] = validation_errors();
			$data['result'] = "error";
			
		}
		$this->load->view('json_view',  array('data'=>$data));
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]', array('matches' => lang('Passwords coincide')));
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form
				
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				//$this->data['message'] = validation_errors();

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;
				
				//$this->_render_page('auth/reset_password', $this->data);
				$this->_render_page($this->config->item('theme_path_frontend'). 'header', $this->data);
				$this->_render_page($this->config->item('theme_path_frontend'). 'nav', $this->data);
				$this->_render_page($this->config->item('theme_path_frontend'). 'content/recuperar_password_nueva', $this->data);
				$this->_render_page($this->config->item('theme_path_frontend'). 'footer', $this->data);
				
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("principal/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('principal/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("principal/recuperar_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			$user = $this->ion_auth->user($id)->row();
			$this->data['nombre'] = $user->username;
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());			
			$this->load->view($this->config->item('theme_path_frontend'). 'header');
			$this->load->view($this->config->item('theme_path_frontend'). 'nav');
			$this->load->view($this->config->item('theme_path_frontend'). 'content/registre_ok', $this->data);
			$this->load->view($this->config->item('theme_path_frontend'). 'footer');
			
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("ajax/auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			
			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	// create a new user
	public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            //redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
			
			$this->_render_page('auth/create_user', $this->data);
        }
    }

	// edit a user
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);
		
		$this->_render_page('auth/edit_user', $this->data);
	}

	// create a new group
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);
			
			$this->_render_page('auth/create_group', $this->data);
		}
	}

	// edit a group
	public function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);
	
		$this->_render_page('auth/edit_group', $this->data);
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

}