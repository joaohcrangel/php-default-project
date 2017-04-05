<?php 

namespace Hcode\SQL;

class Tables extends \Collection {
	
	protected $class = "SQL\Table";
	protected $pk = "";

	public function get(){}

	public static function listAll(){

		$tables = new Tables();

		$tables->loadFromQuery("SHOW TABLE STATUS FROM ".DB_NAME.";");

		return $tables;

	}

}

?>