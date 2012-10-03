<?php

class current_user {

	private static $user;

	public function __construct() {}

	public static function user($db) {

		if(!isset(self::$user)) {

			$CI = & get_instance();
			$CI->load->library('session');

			if (!$user_id = $CI->session->userdata('user_id')) {
				return FALSE;
			}
                        
                        $query = USUARIOS . " WHERE id_usuario='" . $user_id ."'";
                        $u = $db->query($query)->row();
			
                        if (!$u) {
				return FALSE;
			}

			self::$user = $u;
		}

		return self::$user;
	}
        
	public static function login($db, $username, $password) {
                
                $query = USUARIOS . " WHERE usuario='" . $username . "' AND clave='" . $password."'";
                $u = $db->query($query)->row();
                
                if ($u) {
                    
			// this mutates (encrypts) the input password
//			$u_input = new \Admin\Usuario();
//			$u_input->setPassword($password);

			// password match (comparing encrypted passwords)
			if ($u->clave == $password) {

				unset($u_input);

				$CI =& get_instance();
				$CI->load->library('session');
				$CI->session->set_userdata('user_id',$u->id_usuario);
				self::$user = $u;

				return TRUE;
			}

			unset($u_input);
		}

		// login failed
		return FALSE;

	}
        
        public static function getDefaultHomeController(){
            $CI =& get_instance();
            return $CI->doctrine->em->getRepository('Admin\Usuario')->getDefaultHomeController(self::$user);
        }
        
        public static function tienePermiso($feature = null){
            return true;
        }
        
        public static function getFeaturesMenuPrincipal(){
            
                $user = self::user();
                
                if(isset($user) && is_object($user)) {
                
                    $perfiles = $user->getPerfiles();

                    $features = array();

                    foreach ($perfiles as $perfil) {
                        $permisos = $perfil->getPermisos();
                        foreach ($permisos as $permiso) {

                            $feature = $permiso->getFeature();

                            if(is_null($feature->getConfigDialog())){
                                $features[] = 
                                        array(
                                                'uri' => $feature->getTitulo()
                                            ,   'title'=> $feature->getTituloPlural()
                                        );
                            }
                        }

                    }

                    return $features;
                }
                else{
                    redirect('admin/login_form');
                }
            //}
        }
        
        
        public static function getFeaturesMenuLateral(){
            
            $user = self::user();
            $perfiles = $user->getPerfiles();
            
            $features = array();
            
            foreach ($perfiles as $perfil) {
                $permisos = $perfil->getPermisos();
                
                foreach ($permisos as $permiso) {
                    $feature = $permiso->getFeature();
                    
                    $titulo = strtolower($feature->getTitulo());
                    $tituloPlural = $feature->getTituloPlural();
                    $configDialog = $feature->getConfigDialog();
                    
                    $height = HEIGHT_DIALOG_FORM;
                    $width = WIDTH_DIALOG_FORM;
                    
                    if(is_object($configDialog)){
                        $height = $configDialog->getHeight();
                        $width = $configDialog->getWidth();
                    }
                    
                    //\Helpers\ORM::dump($configDialog);
                    
                    $str_modulo = strtolower($feature->getModulo()->getNombre());
                    
                    if(!is_null($feature->getConfigDialog())){
                    
                        $features[$titulo] = 
                                array(
                                    'list' => array(
                                            'controller' => $str_modulo . '/' . $titulo . '_list'
                                        ,   'text' => $tituloPlural
                                    )
                                ,
                                    'form' => array(
                                            'controller' => $str_modulo . '/' . $titulo . '_form'
                                        ,   'title' =>  'Nuevo registro de <b>'. $titulo .'</b>'
                                        ,   'height' =>  $height
                                        ,   'width' =>  $width
                                    )
                        );
                    }
                }
            }
            
            return $features;
            
        }

	public function __clone() {
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}

}
