<?php
class Session extends DefaultObject {

	public static function setObjectInSession($object){

		if(gettype($object) === 'object' && method_exists($object, "getFields")){
			$_SESSION[get_class($object)] = $object->getFields();
		}else{
			$_SESSION[get_class($object)] = $object;
		}

		return $object;

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

	public static function getCollectionFromSession($class_name){

		if(isset($_SESSION[$class_name])){
			try{
				$col = new $class_name();
				$modelName = $col->getModelName();
				foreach ($_SESSION[$class_name] as $data) {
					$col->add(new $modelName($data));
				}
				return $col;
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

	public static function getPessoa():Pessoa
	{

		return Session::getUsuario()->getPessoa();

	}

	public static function getUsuario($lockRedirect = true):Usuario
	{

		if(isset($_SESSION[Usuario::SESSION_NAME_LOCK])){
			if ($lockRedirect === true) {
				header('Location: '.SITE_PATH.'/'.DIR_ADMIN.'/lock');
				exit;
			}
		}

		$usuario = Session::getObjectFromSession('Usuario');

		if ($usuario !== NULL && !$usuario->getidusuario() > 0) {

			$cookie = getLocalCookie(COOKIE_KEY);

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
	
	public static function setUsuario(\Usuario $usuario, $inCookie = false):Usuario
	{

		if ($inCookie === true) {

			setLocalCookie(COOKIE_KEY, session_id(), time()+(60*60*24*5));

		}

		return Session::setObjectInSession($usuario);
		
	}

	public static function checkLogin($redirect = false)
	{

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

	public static function getUsuariosLogs():UsuariosLogs
	{

		if (!isset($_SESSION[UsuarioLog::SESSION])) {
			$_SESSION[UsuarioLog::SESSION] = array();
		}

		$usuariosLogs = new UsuariosLogs();

		foreach($_SESSION[UsuarioLog::SESSION] as $usuarioLog){

			$usuariosLogs->add(new UsuarioLog($usuarioLog));

		}

		return $usuariosLogs;

	}

	public static function clearUsuariosLogs()
	{

		$_SESSION[UsuarioLog::SESSION] = array();

	}

	public static function addUsuarioLog()
	{

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

	public static function setConfiguracoes(Configuracoes $configs)
	{

		return Session::setObjectInSession($configs);

	}

	public static function getConfiguracoes():Configuracoes
	{

		return Session::getCollectionFromSession('Configuracoes');

	}
	
}
?>
