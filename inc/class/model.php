<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
interface ModelInterface {

    public function get($primarykey);
    public function save();
    public function remove();

}

abstract class Model implements ModelInterface {
  
	protected $fields = NULL;
	private $changed = false;
	
	public function __construct(){
		
		$args = func_get_args();
		
		$this->fields = (object)array();
		
		switch(count($args)){
			
			case 1:
				$arg = $args[0];
				switch(gettype($arg)){
					case 'integer':
					$this->get($arg);
					$this->setSaved();
					break;
					case 'array':
					$this->setChanged();
					$this->arrayToAttr($arg);
					break;
					case 'object':
					$this->{"getBy".get_class($arg)}($arg);
					break;
				}
			break;
			
		}
		
	}
	
	private function isValid($silient = false){
		
		$valid = true;
		
		if(gettype($this->required)=='array'){
		
			foreach($this->required as $field){
				
				if($this->fields->{$field}===NULL){
					
					if(!$silient) throw new Exception("O campo ".$field." é obrigatório para savar o objeto ".get_class($this).".", 1);
					
					$valid = false;
					
				}
				
			}

			return $valid;
			
		}else{
			
			return $valid;
			
		}
		
	}
	
	public function __call($name, $args){
		
		if($name === 'get' && method_exists($this, $name)){
			
			$return = call_user_func_array(array($this,$name), $args);
			
			$this->setSaved();
			
			return $return;
			
		}elseif($name === 'save' && method_exists($this, $name) && $this->isValid()){
			
			return call_user_func_array(array($this,$name), $args);
		
		}else{
		
			//Crindo Getters e Setters automaticamento
			if(!method_exists($this, $name) && strlen($name)>3 && in_array(substr($name,0,3), array('get', 'set'))){
				
				if(substr($name,0,3)=='get'){
					
					//Getters
					$namefield = substr($name,3,strlen($name)-3);

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
	
	private function arrayToAttr($array){
		
		$this->fields = (object)$array;
		
	}
	
	private function getSql(){
		
		return ($this->fields->Sql)?$this->fields->Sql:$this->setSql(new Sql());
		
	}
	
	private function queryToAttr($query){
		
		$sql = $this->getSql();
		$result = $sql->arrays($query, true);
		$this->arrayToAttr($result);
		return $result;
			
	}
	
	private function queryGetID($query){
		
		$sql = $this->getSql();
		$result = $sql->arrays($query, true);
		return (int)$result['_id'];
			
	}
	
	private function execute($query){
		
		$sql = $this->getSql();
		$sql->query($query);
		return true;
		
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
	
	/** Carrega o objeto se não estiver completo : void */
	final private function getIfNotLoaded(){

		if(isset($this->required) && gettype($this->required) === 'array' && isset($this->pk)){

			if(!$this->pk > 0) throw new Exception("Informe o ".$this->pk." do objeto.", 1);

			$load = false;
			foreach ($this->required as $req) {
				if(!$this->{'get'.$req}()){
					$load = true;
					break;
				}
			}

			if($load === true){

				$this->get($this->{'get'.$this->pk}());

			}

		}

	}
 
}
?>
