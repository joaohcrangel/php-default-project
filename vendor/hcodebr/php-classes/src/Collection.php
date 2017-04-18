<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
namespace Hcode;

abstract class Collection extends Model {
  
	protected $itens = array();
	protected $type = "object";
	protected $class = "stdClass";
	protected $pk = "id";

	//* Exemplo */
	//protected $saveQuery = "EXECUTE sp_model_save ?, ?";
	//protected $saveArgs = array("idmodel","desmodel");	

	public function get(){}

	/** Insere um novo item na coleção : Mixed */
	public function add($object){

		if(gettype($object) === "object" && get_class($object) === $this->class){

			array_push($this->itens, $object);

			return $object;

		}elseif(gettype($object) === "object" && gettype($this->class) === "array" && in_array(get_class($object), $this->class)){

			array_push($this->itens, $object);

			return $object;
			
		}elseif(gettype($object) === $this->type){

			array_push($this->itens, $object);

			return $object;

		}elseif(gettype($this->type) === "array" && in_array(gettype($object), $this->type)){

			array_push($this->itens, $object);

			return $object;

		}else{

			throw new Exception("A coleção não aceito o tipo ".gettype($object).".");

		}

	}

	/** Remove um item da coleção e o retorna : boolean/Mixed */
	public function remove(){

		$object = func_get_arg(0);

		if(!isset($object) || $object == NULL) throw new Exception("Informe o objeto que será removido");

		$itens = array();
		$removed = false;		

		if($this->type === "object"){
			foreach ($this->itens as $item) {
				if($item->{'get'.$this->pk} === $object->{'get'.$this->pk}){
					$removed = $item;
				}else{
					array_push($itens, $item);
				}
			}
		}else{
			foreach ($this->itens as $item) {
				if($item === $object){
					$removed = $item;
				}else{
					array_push($itens, $item);
				}
			}
		}

		$this->itens = $itens;

		return $removed;

	}

	public function &getItens()
	{

		return $this->itens;

	}

	public function loadFromQuery($query, $params = array())
	{

		return $this->load($this->getSql()->arrays($query, false, $params));

	}

	public function load($data)
	{

		if(!gettype($data) === "array") throw new Exception("Uma coleção só pode definir itens à partir de um Array");

		$this->itens = array();

		foreach ($data as $item) {
			$this->add(new $this->class($item));
		}

		return $this->getItens();

	}

	public function setItens($itens){

		if(!gettype($itens) === "array") throw new Exception("Uma coleção só pode definir itens à partir de um Array");

		$this->itens = array();

		foreach ($itens as $item) {
			$this->add($item);
		}

		return $this->getItens();

	}

	public function getSize(){

		return count($this->itens);

	}

	/** Converte a coleção em Array : array */
	public function getFields(){

		$fields = array();

		foreach ($this->itens as $item) {
			if(gettype($item) === "object"){
				array_push($fields, $item->getFields());
			}else{
				array_push($fields, $item);
			}
		}

		return $fields;

	}

	/** Retorna os itens alterados : array */
	public function &getChangedItens(){

		$itens = array();

		foreach ($this->itens as $object) {
			if($object->getChanged()) array_push($itens, $object);
		}

		return $itens;

	}
	
	/** Salva todos os modelos alterados da coleção : boolean */
	public function save(){

		if(!isset($this->saveQuery)) throw new Exception("A coleção não possui o atributo saveQuery");
		if(!isset($this->saveArgs)) throw new Exception("A coleção não possui o atributo saveArgs");

		$itens = &$this->getChangedItens();

		$querys = array();
		$params = array();

		foreach ($itens as $item) {
			
			if(method_exists($item, "beforesave")) $item->beforesave();

			array_push($querys, $this->saveQuery);

			$args = array();
			foreach ($this->saveArgs as $arg) {
				array_push($args, $item->{"get".$arg}());
			}

			unset($arg);

			array_push($params, $args);

		}

		unset($args);

		for ($i = 0; $i < count($querys); $i++) {

			$q = $querys[$i];
			$param = $params[$i];

			$querys[$i] = $this->getSql()->proc($q, $param, true);
			
		}

		$results = $this->getSql()->querys($querys, $params);

		$success = true;

		for ($i = 0; $i < count($itens); $i++) {
			
			$item = $itens[$i];
			$result = $results[$i][0];

			if(isset($result[$this->pk])){

				$item->{'set'.$this->pk}((int)$result[$this->pk]);
				if(method_exists($item, "aftersave")) $item->aftersave();
				$item->setSaved();

			}else{

				$success = false;

			}

		}

		unset($result, $results, $item, $querys);

		return $success;

	}

	protected function rowsToItens($rows){

		if(gettype($rows) === "array" && count($rows)){

	    	foreach ($rows as $row) {
	    		if($this->type === "object"){
	    			$this->add(new $this->class($row));	
	    		}else{
					$this->add($row);
	    		}	    		
	    	}

	    	return $this->getItens();

		}else{

			return false;

		}

    }

    public function getFirst(){

    	if($this->getSize() > 0){

    		return $this->itens[0];

    	}else{

    		return NULL;

    	}

    }

    public function getLast(){

    	if($this->getSize() > 0){

    		return $this->itens[($this->getSize()-1)];

    	}else{

    		return NULL;

    	}

    }

    public function find($field, $value){

    	foreach ($this->itens as $object) {
    		
    		if($object->{"get".$field}() === $value){

    			return $object;

    		}

    	}

    	return false;

    }

    public function filter($field, $value){
    	$colName = get_class($this);
    	$filtrated = new $colName();
    	foreach ($this->getItens() as $object) {
    		if($object->{"get".$field}() === $value){
    			$filtrated->add($object);
    		}
    	}
    	return $filtrated;
    }

    public function filterBy($fieldsAndValues = array()){
    	$colName = get_class($this);
    	$filtrated = new $colName();
    	foreach ($this->getItens() as $object) {
    		$is = true;
    		foreach ($fieldsAndValues as $key => $value) {
    			if($object->{"get".$key}() !== $value) $is = false;
    		}
    		if($is === true) $filtrated->add($object);
    	}
    	return $filtrated;
    }

    private function aasort(&$array, $key) {
	    $sorter=array();
	    $ret=array();
	    reset($array);
	    foreach ($array as $ii => $va) {
	        $sorter[$ii]=$va[$key];
	    }
	    asort($sorter);
	    foreach ($sorter as $ii => $va) {
	        $ret[$ii]=$array[$ii];
	    }
	    $array=$ret;
	}
	public function sort($key) {
		$itens = $this->getFields();
		$this->aasort($itens, $key);
		$this->itens = array();
		$this->rowsToItens($itens);
		return $this->getItens();
	}

	public function setType($type){
		$this->type = $type;
	}

	public function setClass($class){
		if(!class_exists($class)) throw new Exception("A classe $class não existe.");
		$this->type = "object";
		$this->class = $class;
	}

	public function toString($field){

		$fields = array();

		foreach ($this->getItens() as $object) {
			array_push($fields, $object->{'get'.$field}());
		}

		return implode(",", $fields);

	}

	public function getModelName(){

		return $this->class;

	}
	
}
?>
