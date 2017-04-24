<?php
/*
 * @AUTHOR João Rangel
 * joaohcrangel@gmail.com
 *
 */
namespace Hcode;

use Hcode\Locale\Language;
use Hcode\Sql;

interface ModelInterface {

	public function get();
    public function save();
    public function remove();

}

abstract class Model extends DefaultObject implements ModelInterface {

	protected $sql = NULL;
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
					$this->{"getBy".str_replace("\\", "_", get_class($arg))}($arg);
					break;
					case 'string':
					$this->getbystring($arg);
					$this->setSaved();
					break;
				}
			break;
			default:
			if (count($args) > 0) {
				call_user_func_array(array($this, 'get'), $args);
				//call_user_method_array('get', $this, $args);
			}
			break;

		}

	}

	protected function isValid($silient = false){

		$valid = true;

		if(gettype($this->required)=='array'){

			foreach($this->required as $field){

				if(!isset($this->fields->{$field}) || $this->fields->{$field}===NULL){

					if(!$silient) throw new Exception("O campo ".$field." é obrigatório para salvar o objeto ".get_class($this).".", 1);

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

	protected function arrayToAttr($array){

		foreach ((array)$array as $key => $value) {

			switch(substr($key, 0, 3)){
				case 'des':
				$this->{"set".$key}($value);
				break;
				default:
				switch(substr($key, 0, 2)){

					case "id":
					case "nr":
					if($value !== NULL) $this->{"set".$key}((int)$value);					
					break;

					case "vl":
					if(strpos($value, ",") !== false) {
						$value = str_replace(",", ".", str_replace(".", "", $value));
					}
					$this->{"set".$key}((float)$value);
					break;

					case "in":
					case "is":
					$this->{"set".$key}((bool)$value);
					break;

					case "dt":
					if (!$value) {
						$this->{"set".$key}(NULL);
					} else {
						$weekdays = Language::getWeekdays();
						$this->{"set".$key}(date("Y-m-d", $this->dateToTimestamp($value)));
						$this->{"setdes".$key}(date("d/m/Y", $this->dateToTimestamp($value)));
						$this->{"setdesweek".$key}(date("w", $this->dateToTimestamp($value)));
						$this->{"setdesweekday".$key}($weekdays[date("w", $this->dateToTimestamp($value))]['desweekday']);
						$this->{"sethr".$key}(date("H:i:s", $this->dateToTimestamp($value)));
						$this->{"setiso".$key}(date("c", $this->dateToTimestamp($value)));
						$this->{"setts".substr($key, 2, strlen($key))}($this->dateToTimestamp($value));
					}
					break;

					default:
					$this->{"set".$key}($value);
					break;

				}
				break;
			}

		}

	}

	protected function getSql(){

		return (isset($this->sql) && $this->sql !== NULL)?$this->sql:$this->sql = new Sql();

	}

	protected function queryToAttr($query, $params = array()){

		$sql = $this->getSql();
		$result = $sql->select($query, $params);		
		$this->arrayToAttr($result);
		return $result;

	}

	protected function execute($query, $params = array()){

		$sql = $this->getSql();
		return $sql->query($query, $params);

	}

	protected function proc($query, $params = array()){

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

	public function toJSON(){

		return json_encode($this->getFields());

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

	public function getPkName(){

		return $this->pk;

	}

	public function checkPkValue(){

		return ((int)$this->{'get'.$this->pk}() > 0)?true:false;

	}

	public function reload(){

		return $this->get($this->{'get'.$this->pk}());

	}

}
?>
