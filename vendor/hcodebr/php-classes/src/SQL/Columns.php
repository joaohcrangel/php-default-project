<?php 

namespace Hcode\Sql;

use Hcode\Collection;

class Columns extends Collection {
	
	protected $class = "Hcode\Sql\Column";
	protected $pk = "";

	public function get(){}

	private function getVariablePrefix(){

		switch(DB_TYPE){

			case 1:
			case 3:
			return "p";
			break;
			case 2:
			return "@";
			break;

		}

	}

	public function getArrayFields(){

		$data = array();

		foreach ($this->getItens() as $column) {
			array_push($data, $column->getCOLUMN_NAME());
		}

		return $data;

	}

	public function getArrayFieldsTypes(){

		$data = array();

		foreach ($this->getItens() as $column) {
			array_push($data, $column->getDATA_TYPE());
		}

		return $data;

	}

	public function getArrayFieldsRequireds(){

		$data = array();

		foreach ($this->getItens() as $column) {

			if($column->getinnull() === false && !$column->getCOLUMN_DEFAULT() && $column->getinpk()===false){
				array_push($data, "'".$column->getCOLUMN_NAME()."'");
			}

		}

		return $data;

	}

	public function getStringFieldsRequireds(){

		return implode(", ", $this->getArrayFieldsRequireds());

	}

	public function getArrayFieldsSave(){

		$data = array();

		foreach ($this->getItens() as $column) {
			if($column->getCOLUMN_NAME() !== "dtcadastro" && (($column->getDATA_TYPE() !== "timestamp" && $column->getCOLUMN_DEFAULT() !== "CURRENT_TIMESTAMP") || ($column->getDATA_TYPE() !== "datetime" && $column->getCOLUMN_DEFAULT() !== "(getdate())"))){

				array_push($data, '$this->get'.$column->getCOLUMN_NAME().'()');

			}
		}

		return $data;

	}

	public function getStringFieldsSave(){

		return implode(",\n                ", $this->getArrayFieldsSave())."\n";

	}

	public function getArrayFieldsSaveArgs(){

		$data = array();

		foreach ($this->getArrayFieldsNotDtCadastroDefault() as $column) {
			array_push($data, '"'.$column->getCOLUMN_NAME().'"');
		}

		return $data;

	}

	public function getArrayFieldsNotDtCadastroDefault(){

		$data = array();

		foreach ($this->getItens() as $column) {

			if(
				$column->getCOLUMN_NAME() !== "dtcadastro" 
				&& 
				(
					($column->getDATA_TYPE() !== "timestamp" && $column->getCOLUMN_DEFAULT() !== "CURRENT_TIMESTAMP") 
					|| 
					($column->getDATA_TYPE() !== "datetime" && $column->getCOLUMN_DEFAULT() !== "(getdate())")
				)
			){

				array_push($data, $column);

			}

		}

		return $data;

	}

	public function getArrayFieldsSaveParams(){

		$data = array();

		foreach ($this->getArrayFieldsNotDtCadastroDefault() as $column) {

			switch($column->getDATA_TYPE()){

				case 'varchar':
				case 'char':
				array_push($data, $this->getVariablePrefix().$column->getCOLUMN_NAME()." ".strtoupper($column->getDATA_TYPE())."(".$column->getCHARACTER_MAXIMUM_LENGTH().")");
				break;

				case 'decimal':
				array_push($data, $this->getVariablePrefix().$column->getCOLUMN_NAME()." ".strtoupper($column->getDATA_TYPE())."(".$column->getNUMERIC_PRECISION().",".$column->getNUMERIC_SCALE().")");
				break;

				default:
				array_push($data, $this->getVariablePrefix().$column->getCOLUMN_NAME()." ".strtoupper($column->getDATA_TYPE()));
				break;

			}

		}

		return $data;

	}

	public function getStringFieldsUpdate(){

		$data = array();

		foreach ($this->getArrayFieldsNotDtCadastroDefault() as $column) {

			if(!$column->getinpk()){

				array_push($data, $column->getCOLUMN_NAME()." = ".$this->getVariablePrefix().$column->getCOLUMN_NAME());

			}

		}

		return implode(",\n            ", $data);

	}

	public function getStringFieldsSaveParams(){

		return implode(",\n", $this->getArrayFieldsSaveParams())."\n";

	}

	public function getArrayFieldsSaveInsert(){

		$data = array();

		foreach ($this->getArrayFieldsNotDtCadastroDefault() as $column) {

			if(!$column->getinpk()){

				array_push($data, $column->getCOLUMN_NAME());

			}

		}

		return $data;

	}

	public function getStringFieldsSaveInsert(){

		return implode(", ", $this->getArrayFieldsSaveInsert());

	}

	public function getArrayFieldsSaveInsertVars(){

		$data = array();

		foreach ($this->getArrayFieldsSaveInsert() as $column_name) {

			array_push($data, $this->getVariablePrefix().$column_name);

		}

		return $data;

	}

	public function getStringFieldsSaveInsertVars(){

		return implode(", ", $this->getArrayFieldsSaveInsertVars());

	}

	public function getStringFieldsSaveArgs(){

		return implode(", ", $this->getArrayFieldsSaveArgs());

	}

	public function getArrayParams(){

		$data = array();

		foreach ($this->getArrayFieldsSave() as $column) {
			array_push($data, "?");
		}

		return $data;

	}

	public function getStringParams(){

		return implode(", ", $this->getArrayParams());

	}

	public function getArrayPrimaryKey(){

		$data = array();

		foreach ($this->getItens() as $column) {
			if($column->getinpk()) array_push($data, $column->getCOLUMN_NAME());
		}

		return $data;

	}

	public function getArrayInsertPrimaryKey(){

		$data = array();

		foreach ($this->getItens() as $column) {
			if($column->getinpk()) array_push($data, "@".$column->getCOLUMN_NAME());
		}

		return $data;

	}

	public function getStringPrimaryKey(){

		$pks = $this->getArrayPrimaryKey();

		if(count($pks)>1){

			foreach ($pks as &$pk) {
				$pk = '"'.$pk.'"';
			}

			return implode(", ", $pks);

		}else{

			return $pks[0];

		}

	}
	
}

?>