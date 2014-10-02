<?php 

class Animal extends Model {

	public $estaVivo = true;

	public function andar(){

		if($this->estaVivo == true) echo "O animal está andando...";

	}

}

?>