<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
interface ModelInterface {

	public function get();
    public function save();
    public function remove();

}

abstract class Model extends DefaultObject implements ModelInterface {

	private $sql = NULL;
	protected $pk;
	
	public function __construct(){
		
		$args = func_get_args();
		
		if(!isset($this->fields)) $this->fields = (object)array();
		
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
					case 'string':
					$this->getbystring($arg);
					$this->setSaved();
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
	
	public function set($data){

		$this->arrayToAttr($data);

	}

	private function arrayToAttr($array){

		foreach ($array as $key => $value) {
			
			$this->{"set".$key}($value);

		}
		
	}
	
	private function getSql(){
		
		return (isset($this->sql) && $this->sql !== NULL)?$this->sql:$this->sql = new Sql();
		
	}
	
	private function queryToAttr($query, $params = array()){
		
		$sql = $this->getSql();
		$result = $sql->proc($query, $params);
		$this->arrayToAttr($result[0]);
		return $result;
			
	}
	
	private function execute($query, $params = array()){
		
		$sql = $this->getSql();
		return $sql->query($query, $params);
		
	}

	private function proc($query, $params = array()){
		
		$sql = $this->getSql();
		return $sql->proc($query, $params);
		
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

	public function getFields(){

		$fields = (array)$this->fields;

		unset($fields['conn'], $fields['Sql']);

		foreach ($fields as &$f) {
			if(gettype($f) === 'object' && method_exists($f, "getFields")){
				$f = $f->getFields();
			}elseif(gettype($f) === 'object'){
				$f = (array)$f;
			}
		}

		return $fields;

	}

	public function checkPkValue(){

		return ((int)$this->{'get'.$this->pk}() > 0)?true:false;

	}
 
}
?>
