<?php

namespace Hcode;

class DefaultObject {

	protected $fields = NULL;
	private $changed = false;

	public function __call($name, $args){

		if(!isset($this->fields)) $this->fields = (object)array();

		if($name === 'get' && method_exists($this, $name)){

			$return = call_user_func_array(array($this,$name), $args);

			$this->setSaved();

			return $return;

		}elseif($name === 'save' && method_exists($this, $name) && $this->isValid()){

			return call_user_func_array(array($this,$name), $args);

		}else{

			//Criando Getters e Setters automaticamente
			if(!method_exists($this, $name) && strlen($name)>3 && in_array(substr($name,0,3), array('get', 'set'))){

				if(substr($name,0,3) == 'get'){

					//Getters
					$namefield = substr($name,3,strlen($name)-3);

					if (
						$this->pk === $namefield &&
						!isset($this->fields->{$namefield})
					) {
						return $this->fields->{$namefield} = 0;
					}

					if(!isset($this->fields->{$namefield})) return NULL;

					if(gettype($namefield) === "object" && !in_array(get_class($namefield), array("DateTime"))){

						return $this->fields->{$namefield};

					}

					switch(substr($namefield, 0, 3)){

						case "des":
						return (string)$this->fields->{$namefield};
						break;

					}

					switch(substr($namefield, 0, 2)){

						case "id":
						if(!$this->fields->{$namefield} > 0) $this->fields->{$namefield} = 0;
						return (int)$this->fields->{$namefield};
						break;

						case "nr":
						return (int)$this->fields->{$namefield};
						break;

						case "vl":
						$value = $this->fields->{$namefield};
						if(strpos($value, ",") !== false) $value = str_replace(",", ".", str_replace(".", "", $this->fields->{$namefield}));
						return (float)$value;
						break;

						case "in":
						case "is":
						return (bool)$this->fields->{$namefield};
						break;

						case "dt":
						return (string)date("Y-m-d H:i", $this->dateToTimestamp($this->fields->{$namefield}));
						break;

						default:
						return $this->fields->{$namefield};
						break;

					}

				}else{

					//Setters
					$this->setChanged();
					$this->fields->{substr($name,3,strlen($name)-3)} = $args[0];
					return $args[0];

				}

			}else{
				//var_dump($name);
	        	if($this) return call_user_func_array(array($this,$name),$args);

			}

		}

	}

	public function getChanged(){

		return $this->changed;

	}

	public function setChanged(){

		$this->changed = true;

	}

	public function setSaved(){

		$this->changed = false;

	}

	public function dateToTimestamp($value){

		if(is_numeric($value) && gettype($value) !== "integer"){
			$value = (int)$value;
		}

		switch(gettype($value)){

			case "integer":
			return $value;
			break;

			case "object":
			return $value->format("U");
			break;

			case "string":
			return strtotime($value);
			break;

		}

	}

	public function getObjectOrCreate($className, $pkValue){

		$obj = new $className();

		if (
			isset($this->fields->{$className})
		) {

			if (
				gettype($this->fields->{$className}) === 'object'
				&&
				get_class($this->fields->{$className}) === $className
			) {
				return $this->fields->{$className};
			} else {
					return new $className($this->fields->{$className});
			}

		}

		$pks = array();

		if (gettype($obj->getPkName()) === 'array') {
			$pks =  $obj->getPkName();
		} else {
			array_push($pks, $obj->getPkName());
		}

		foreach ($pks as $pk) {
			if (!$this->{'get'.$pk}() > 0) throw new Exception("Não há ".$pk.".");
		}

    	unset($obj);

    	return $this->fields->{$className} = new $className($pkValue);

	}

	public static function getFirstDateTime($year, $month){

		return new DateTime("{$year}-{$month}-1");

	}

	public static function getLastDateTime($year, $month){

		return new DateTime(date("Y-m-t", strtotime("{$year}-{$month}-1")));

	}

	public static function toMask($mask, $str):string
	{

	    for($i=0;$i<strlen($str);$i++){

	    	$mask[strpos($mask,"#")] = $str[$i];	
	    	
	    }

	    return $mask;

	}

}
?>
