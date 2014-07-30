<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
class Model {
  
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
		
		if($name == 'save'){
			
			if(method_exists($this, $name) && $this->isValid()){
			
				return call_user_func_array(array($this,$name), $args);
			
			}
			
		}else{
		
			//Crindo Getters e Setters automaticamento
			if(!method_exists($this, $name) && strlen($name)>3 && in_array(substr($name,0,3), array('get', 'set'))){
				
				if(substr($name,0,3)=='get'){
					
					//Getters
					return $this->fields->{substr($name,3,strlen($name)-3)};
				
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
	
	private function getChanged(){
		
		return $this->changed;
			
	}
	
	private function setChanged(){
		
		$this->changed = true;
			
	}
	
	private function setSaved(){
		
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
