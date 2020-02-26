<?php
class Profile extends MY_Controller {
		

	public function __construct(){
		parent::__construct();	
		if (!$this->ion_auth->logged_in()) redirect(base_url($this->lang->lang().'/principal'), 'refresh'); 	
		
	}
	
	public function index(){	
		
	}
	
	public function update_profile(){
				
		$data = array();
		$params = array();		
		$params['name'] = $this->input->post('username');
		$params['surnames'] = $this->input->post('surnames');
		$params['telephone'] = $this->input->post('telephone');
		$params['age'] = $this->input->post('age');
		$params['facebook'] = $this->input->post('facebook');
		$params['twitter'] = $this->input->post('twitter');
		$params['linkedin'] = $this->input->post('linkedin');
		$params['profession'] = $this->input->post('profession');
		$params['laboralstate'] = $this->input->post('laboralstate');
		
		$user_id = $this->data['user']->id; 		
		$profile = $this->profilemodel->getProfileByUserID($user_id);

		$ruta = "uploads/profiles/id".$user_id."/";
		if(!file_exists($ruta)){
			mkdir($ruta, 0777, true);
		}

		foreach($_FILES as $key){	           
            if($key['error'] == UPLOAD_ERR_OK ){	            	
			    $originalFileName = $key['name'];
			    //Se obtiene la posicion del punto del fichero
				$positionOfDot =  strripos($originalFileName, ".");
				///Se obtiene el formato de la imagen
				$formatOfImage = strtolower(substr($originalFileName,$positionOfDot));
				$mimeformatfile = $key['type'];
				$mimeformatcalc = "image/".substr($formatOfImage, 1);
				if($mimeformatcalc != $mimeformatfile){
					$formatOfImage = ".".substr($mimeformatfile, 6);
				}
			    $nombre = "profile_".uniqid();
			    $uploadthumb = $ruta.$nombre."_thumb".$formatOfImage;
			    $nombreext = $nombre.$formatOfImage;
			    $temporal = $key['tmp_name'];
			    $nombre = preg_replace('/\s+/', '', $nombreext);
			    $uploadfile = $ruta.$nombreext;	
				move_uploaded_file($temporal, $uploadfile);

				$params['image'] = $uploadfile;

				chmod($uploadfile, 0777);
				
				if($formatOfImage == '.jpg' || $formatOfImage == '.jpeg'){
					$original = imagecreatefromjpeg($uploadfile);
				}							
				else if ($formatOfImage == '.png'){
					$original = imagecreatefrompng($uploadfile);
				}		 
				$ancho = imagesx($original);
				$alto = imagesy($original);
				$ancho_final = 300;
				$alto_final = ($ancho_final / $ancho) * $alto;
				$thumb = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($thumb,$original,0,0,0,0,$ancho_final,$alto_final,$ancho,$alto);
				imagejpeg($thumb,$uploadthumb,90); 
				ImageDestroy($thumb);				
			   	
			   	//Se elimina la imagen de perfil anterior del usuario					
				if(isset($profile)){
					$oldpic = $profile->image;
					if(file_exists($oldpic) and $oldpic != 'assets/img/default-profile.png')
					unlink($oldpic);

					//Se elimina el thumbnail de la imagen anterior de usuario
					$positionOfDot = strripos($oldpic, ".");				
					$formatOfImage = substr($oldpic,$positionOfDot);
					$thumbprofilepic = substr_replace($oldpic, "_thumb", $positionOfDot).$formatOfImage; 
					
					if(file_exists($thumbprofilepic))
						unlink($thumbprofilepic);	
				}
			}
		}	
						
		$idprofile = $this->profilemodel->updateProfile($profile->id, $params);					
				
		if($idprofile){
			$data['result']="true";
			$data['profile'] = $this->profilemodel->getProfileByUserID($user_id);
			$data['title']=lang('My Profile');
			$data['detail']=lang('ok_update_profile');			
		}	
		else{
			$data['result']="error";
			$data['detail']=lang('error_update_profile');
		}	
		$this->load->view('json_view',  array('data'=>$data));
	}
	
	


	

}
?>