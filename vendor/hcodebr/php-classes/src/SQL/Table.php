<?php 

namespace Hcode\Sql;

use Hcode\Model;
use Hcode\SQL\Tables;

class Table extends Model {
	
	public function get(){}
	public function save(){}
	public function remove(){}

	public static function loadFromName($Name){

		$table = new Table();

		$table->queryToAttr("SHOW TABLE STATUS FROM ".DB_NAME." WHERE Name = '".$Name."';");

		$table->getColumns();

		return $table;

	}

	public function getTablesReferences(){

		$tables = new Tables();

		$tables->loadFromQuery("
			select table_name
			from information_schema.KEY_COLUMN_USAGE
			where table_schema = ?
			and referenced_table_name = ?;
		", array(
			DB_NAME,
			$this->getName()
		));

		return $tables;

	}

	public function getColumns(){

		if (isset($this->fields->Columns)) {

			return $this->fields->Columns;

		} else {

			if (!$this->getName()) {
				throw new Exception("Informe o nome da tabela.", 400);
			}

			$columns = new Columns();

			$columns->loadFromQuery("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".DB_NAME."' AND TABLE_NAME='".$this->getName()."' ORDER BY ORDINAL_POSITION;");

			return $this->setColumns($columns);

		}

	}

	public function getColumnPrimaryKey(){

		$columns = $this->getColumns();

		$columns->filter("COLUMN_KEY", "PRI");

	}

	public function getSingularName(){

		$object = str_replace(".", "_", ucfirst(str_replace("tb_", "", $this->getName())));
		return substr($object, 0, strlen($object)-1);

	}

	public function getPluralName(){

		return str_replace(".", "_", ucfirst(str_replace("tb_", "", $this->getName())));

	}

	public function getProcedureName($type_proc){

		switch($type_proc){

			case "get":
			return "sp_".strtolower($this->getPluralName())."_get";
			break;

			case "save":
			return "sp_".strtolower($this->getPluralName())."_save";
			break;

			case "remove":
			return "sp_".strtolower($this->getPluralName())."_remove";
			break;

			case "list":
			return "sp_".strtolower($this->getPluralName())."_list";
			break;

		}

		return null;

	}

}

?>