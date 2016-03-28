<?php
class Session extends DefaultObject {

	public static function setObjectInSession($object){

		if(gettype($object) === 'object' && method_exists($object, "getFields")){
			$_SESSION[get_class($object)] = $object->getFields();
		}else{
			$_SESSION[get_class($object)] = $object;
		}

	}

	public static function getObjectFromSession($class_name){

		if(isset($_SESSION[$class_name])){
			try{
				return new $class_name($_SESSION[$class_name]);
			}catch(Exception $e){
				return $_SESSION[$class_name];
			}
		}else{
			try{
				return new $class_name();
			}catch(Exception $e){
				return NULL;
			}
		}

	}

	public static function getUsuario($lockRedirect = true){

		if(isset($_SESSION[SESSION_NAME_LOCK])){
			if ($lockRedirect === true) {
				header('Location: '.SITE_PATH.'/lock');
				exit;
			}
		}

		$usuario = Session::getObjectFromSession('Usuario');

		if (!$usuario->getidusuario() > 0) {

			$cookie = getLocalCookie(SESSION_NAME_REMEMBER);

			if ((int)$cookie['idusuario'] > 0) {

				$usuario = new Usuario((int)$cookie['idusuario']);

			}

		}

		if ($usuario->getidusuario() > 0) {
			return $usuario;
		} else {
			return new Usuario();
		}

	}
	
	public static function setUsuario(\Usuario $usuario){

		return Session::setObjectInSession($usuario);
		
	}
	
}
?>
