<?php 

namespace Hcode\Sql;

use Hcode\Model;
use Hcode\SQL\Tables;
use \Rain\Tpl;

class Table extends Model {
	
	public function get(){}
	public function save(){}
	public function remove(){}

	public static function loadFromName($Name)
	{

		$table = new Table();

		$table->queryToAttr("SHOW TABLE STATUS FROM ".DB_NAME." WHERE Name = '".$Name."';");

		$table->getColumns();

		return $table;

	}

	public function getCreate()
	{

		$result = $this->getSql()->select("SHOW CREATE TABLE ".$this->getName());

		return $result["Create Table"];

	}

	public function getProcedureScriptFromTpl($type)
	{

        $tpl_name = "sp_".$type;

        Tpl::configure(array(
	        "base_url"      => PATH,
	        "tpl_dir"       => PATH."/res/tpl/sql-to-class/",
	        "cache_dir"     => PATH."/res/tpl/tmp/",
	        "debug"         => false,
	        "tpl_ext"		=> "sql"
	    ));

	    $tpl = new Tpl();

	    $columns = $this->getColumns();

	    $columnsRequiredPost = array();

	    foreach ($columnsRequiredPost as &$value) {
	        $value = "'".$value."'";
	    }

	    $columnsRequired = array_unique(array_merge($columnsRequiredPost, $columns->getArrayFieldsRequireds()));

	    $columnsPksPost = array();

	    foreach ($columnsPksPost as &$value) {
	        $value = "".$value."";
	    }

	    $columnsPks = array_unique(array_merge($columnsPksPost, $columns->getArrayPrimaryKey()));

	    $data = array(
	        "table"=>$this->getName(),
	        "columns"=>$columns->getFields(),
	        "fields"=>implode(", ", $columns->getArrayFields()),
	        "fieldstypes"=>$columns->getArrayFieldsTypes(),
	        "requireds"=>implode(', ', $columnsRequired),
	        "primarykey"=>$columnsPks,
	        "primarykeys"=>implode(', ', $columnsPks),
	        "object"=>ucfirst(post('dessingular')),
	        "object_name"=>strtolower(post('dessingular')),
	        "collection"=>ucfirst(post('desplural')),
	        "rest_name"=>strtolower(post('desplural')),
	        "sp_get"=>$this->getProcedureName("get"),
	        "sp_save"=>$this->getProcedureName("save"),
	        "sp_remove"=>$this->getProcedureName("remove"),
	        "sp_list"=>$this->getProcedureName("list"),
	        "fieldssave"=>$columns->getStringFieldsSave(),
	        "fieldssaveparams"=>$columns->getStringFieldsSaveParams(),  
	        "fieldsinsert"=>$columns->getStringFieldsSaveInsert(),
	        "fieldsinsertp"=>$columns->getStringFieldsSaveInsertVars(),
	        "fieldsupdate"=>$columns->getStringFieldsUpdate(),
	        "params"=>$columns->getStringParams(),
	        "saveArgs"=>$columns->getStringFieldsSaveArgs()
	    );

	    if(gettype($data)=='array'){
	        foreach($data as $key=>$val){
	            $tpl->assign($key, $val);
	        }
	    }

	    $template_code = $tpl->draw($tpl_name, true);

	    $template_code = str_replace( array("&lt;?","?&gt;"), array("<?","?>"), $template_code );

	    return $template_code;

	}

	public function getTablesReferences()
	{

		$tables = new Tables();

		$tables->loadFromQuery("
			select referenced_table_name
			from information_schema.KEY_COLUMN_USAGE
			where table_schema = ?
			and table_name = ?
            and referenced_table_name is not null;
		", array(
			DB_NAME,
			$this->getName()
		));

		return $tables;

	}

	public function getTriggers()
	{

		$triggers = new Collection();

		$triggers->loadFromQuery("
			select trigger_name, event_manipulation, action_timing, action_statement
			from information_schema.triggers
			where trigger_schema = '".DB_NAME."' and event_object_table = '".$this->getName()."';
		");

		return $triggers;

	}

	public function getTriggerCode($name)
	{

		$trigger = $this->getSql()->select("
			select trigger_name, event_manipulation, action_timing, action_statement
			from information_schema.triggers
			where trigger_schema = '".DB_NAME."' and event_object_table = '".$this->getName()."' and trigger_name = '".$name."';
		");

		return "
			CREATE TRIGGER `".DB_NAME."`.`".$name."` ".$trigger['action_timing']." ".$trigger['event_manipulation']." ON `".$this->getName()."` FOR EACH ROW
			".$trigger['action_statement']."
		";

	}

	public function getColumns()
	{

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

	public function getColumnPrimaryKey()
	{

		$columns = $this->getColumns();

		$columns->filter("COLUMN_KEY", "PRI");

	}

	public function getSingularName()
	{

		$object = str_replace(".", "_", ucfirst(str_replace("tb_", "", $this->getName())));
		return substr($object, 0, strlen($object)-1);

	}

	public function getPluralName()
	{

		return str_replace(".", "_", ucfirst(str_replace("tb_", "", $this->getName())));

	}

	public function getProcedureName($type_proc)
	{

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