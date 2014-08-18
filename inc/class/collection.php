<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
abstract class Collection extends Model {
  
	protected $itens = array();
	protected $type = "object";
	protected $class = "stdClass";
	protected $pk = "id";
	
	//* Exemplo */
	//protected $saveQuery = "EXECUTE sp_model_save ?, ?";
	//protected $saveArgs = array("idmodel","desmodel");

	/** Insere um novo item na coleção : Mixed */
	public function add($object){

		if(gettype($object) === "object" && get_class($object) === $this->class){

			array_push($this->itens, $object);

			return $object;

		}elseif(gettype($object) === $this->type){

			array_push($this->itens, $object);

			return $object;

		}else{

			throw new Exception("A coleção não aceito o tipo ".gettype($object).".", 1);

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

	public function getItens(){

		return $this->itens;

	}

	/** Converte a coleção em Array : array */
	public function getFields($array = true){

		$fields = array();

		foreach ($this->itens as $object) {
			array_push($fields, $object->getFields($array));
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

		$results = $this->getSql()->querys($querys, $params);

		$success = true;

		for ($i = 0; $i < count($itens); $i++) { 
			
			$item = $itens[$i];
			$result = $results[$i];

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
	
}
?>
