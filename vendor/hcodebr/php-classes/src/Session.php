<?php

namespace Hcode;

use \Hcode\Person\Person;
use \Hcode\System\User;
use \Hcode\Admin\Menu;
use \Hcode\System\Configurations;
use \Hcode\System\Configuration;

class Session extends DefaultObject {

	const SIMULATE = "SIMULATE";

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
				$class = $class_name;
				return new $class($_SESSION[$class_name]);
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

	public static function getPerson():Person
	{

		return Session::getUser()->getPerson();

	}

	public static function getUser($lockRedirect = true):User
	{

		if(isset($_SESSION[User::SESSION_NAME_LOCK])){
			if (
				$lockRedirect === true 
				&& 
				$_SERVER['REQUEST_URI'] !== SITE_PATH.'/'.DIR_ADMIN.'/lock'
				&& 
				$_SERVER['REQUEST_URI'] !== SITE_PATH.'/users/unlock'
			) {
				header('Location: '.SITE_PATH.'/'.DIR_ADMIN.'/lock');
				exit;
			}
		}

		$user = Session::getObjectFromSession('Hcode\System\User');

		if ($user !== NULL && !$user->getiduser() > 0) {

			$cookie = getLocalCookie(COOKIE_KEY);

			if ((int)$cookie['iduser'] > 0) {

				$user = new User((int)$cookie['iduser']);

			}

		}

		if ($user !== NULL && $user->getiduser() > 0) {
			return $user;
		} else {
			return new User();
		}

	}
	
	public static function setUser(User $user, $inCookie = false):User
	{

		if ($inCookie === true) {

			setLocalCookie(COOKIE_KEY, session_id(), time()+(60*60*24*5));

		}

		return Session::setObjectInSession($user);
		
	}

	public static function checkLogin($redirect = false)
	{

		$user = Session::getUser();

		if (!$user->isLogged()) {

			if ($redirect === true) {

				http_response_code(403);
				header('Location: '.SITE_PATH.'/'.DIR_ADMIN.'/login');
				exit;

			} else {

				if (isset($_GET["token"]) && $_GET["token"] !== '') {

					throw new Exception("Token expirado.", 10100);

				} else {

					throw new Exception("Usuário não autenticado.", 403);
					
				}

			}

		}

	}

	public static function getUsersLogs():UsersLogs
	{

		if (!isset($_SESSION[UserLog::SESSION])) {
			$_SESSION[UserLog::SESSION] = array();
		}

		$usersLogs = new UsersLogs();

		foreach($_SESSION[UserLog::SESSION] as $userLog){

			$usersLogs->add(new UserLog($userLog));

		}

		return $usersLogs;

	}

	public static function clearUsersLogs()
	{

		$_SESSION[UserLog::SESSION] = array();

	}

	public static function addUserLog()
	{

		$user = Session::getUser();

		if ($user->isLogged()) {

			if (!isset($_SESSION[UserLog::SESSION])) {
				$_SESSION[UserLog::SESSION] = array();
			}

			$log = new UserLog(array(
				'iduser'=>$user->getiduser()
			));

			$log->getDefaultValues();

			array_push($_SESSION[UserLog::SESSION], $log->getFields());

		}

	}

	public static function setConfigurations(Configurations $configs)
	{

		return Session::setObjectInSession($configs);

	}

	public static function getConfigurations():Configurations
	{

		return Session::getCollectionFromSession('Hcode\System\Configurations');

	}

	public static function simulateStart(User $user):User
	{

		$_SESSION[Session::SIMULATE] = Session::getUser()->getFields();

		if (!$user->getiduser() > 0) {
			throw new Exception("Informe um objeto User com os dados.");		
		}

		$user->getPerson();

		Session::setUser($user, (isset($_POST['remember'])));

		$configurations = Configurations::listAll();

		Session::setConfigurations($configurations);

		Menu::resetMenuSession();

		return $user;

	}

	public static function isSimulated():bool
	{

		return (isset($_SESSION[Session::SIMULATE]));

	}

	public static function simulateEnd():User
	{

		if (Session::isSimulated()) {

			$user = new User($_SESSION[Session::SIMULATE]);

			unset($_SESSION[Session::SIMULATE]);

			$user->getPerson();

			Session::setUser($user, (isset($_POST['remember'])));

			$configurations = Configurations::listAll();

			Session::setConfigurations($configurations);

			Menu::resetMenuSession();

			return $user;

		} else {
			throw new Exception("Não está simulando um usuário.");
		}

	} 
	
}
?>
