<?php
class Session extends DefaultObject {

	private function setObjectInSession($object){

		if(gettype($object) === 'object' && method_exists($object, "getFields")){
			$_SESSION[$object] = $object->getFields();
		}else{
			$_SESSION[$object] = $object;
		}

	}

	private function getObjectFromSession($class_name){

		if(isset($_SESSION[$class_name])){
			if(class_exists($class_exists)){
				return new $class_name($_SESSION[$class_name]);
			}else{
				return $_SESSION[$class_name];
			}
		}else{
			if(class_exists($class_exists)){
				return new $class_name();
			}else{
				return NULL;
			}
		}

	}
	
}
?>