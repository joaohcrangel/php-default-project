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

	public static function getPessoa(){

		return Session::getUsuario()->getPessoa();

	}

	public static function getUsuario($lockRedirect = true){

		if(isset($_SESSION[Usuario::SESSION_NAME_LOCK])){
			if ($lockRedirect === true) {
				header('Location: '.SITE_PATH.'/'.DIR_ADMIN.'/lock');
				exit;
			}
		}

		$usuario = Session::getObjectFromSession('Usuario');

		if ($usuario !== NULL && !$usuario->getidusuario() > 0) {

			$cookie = getLocalCookie(Usuario::SESSION_NAME_REMEMBER);

			if ((int)$cookie['idusuario'] > 0) {

				$usuario = new Usuario((int)$cookie['idusuario']);

			}

		}

		if ($usuario !== NULL && $usuario->getidusuario() > 0) {
			return $usuario;
		} else {
			return new Usuario();
		}

	}
	
	public static function setUsuario(\Usuario $usuario){

		return Session::setObjectInSession($usuario);
		
	}

	public static function checkLogin($redirect = false){

		$usuario = Session::getUsuario();

		if (!$usuario->isLogged()) {

			if ($redirect === true) {

				http_response_code(403);
				header('Location: '.SITE_PATH.'/'.DIR_ADMIN.'/login');
				exit;

			} else {

				throw new Exception("Usuário não autenticado.", 403);				

			}

		}

	}

	public static function getUsuariosLogs(){

		if (!isset($_SESSION[UsuarioLog::SESSION])) {
			$_SESSION[UsuarioLog::SESSION] = array();
		}

		$usuariosLogs = new UsuariosLogs();

		foreach($_SESSION[UsuarioLog::SESSION] as $usuarioLog){

			$usuariosLogs->add(new UsuarioLog($usuarioLog));

		}

		return $usuariosLogs;

	}

	public static function clearUsuariosLogs(){

		$_SESSION[UsuarioLog::SESSION] = array();

	}

	public static function addUsuarioLog(){

		$usuario = Session::getUsuario();

		if ($usuario->isLogged()) {

			if (!isset($_SESSION[UsuarioLog::SESSION])) {
				$_SESSION[UsuarioLog::SESSION] = array();
			}

			$log = new UsuarioLog(array(
				'idusuario'=>$usuario->getidusuario()
			));

			$log->getDefaultValues();

			array_push($_SESSION[UsuarioLog::SESSION], $log->getFields());

		}

	}
	
}
?>
