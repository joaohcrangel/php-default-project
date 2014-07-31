<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
class Collection extends Model {
  
	protected $itens = array();
	protected $type = "object";
	protected $class = "stdClass";
	protected $pk = "id";

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
	public function remove($object){

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
	
}
?>
