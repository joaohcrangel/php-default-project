<?php
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
		
			//Crindo Getters e Setters automaticamento
			if(!method_exists($this, $name) && strlen($name)>3 && in_array(substr($name,0,3), array('get', 'set'))){
				
				if(substr($name,0,3) == 'get'){
					
					//Getters
					$namefield = substr($name,3,strlen($name)-3);

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
					return true;
						
				}
				
			}else{
			
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

}
?>