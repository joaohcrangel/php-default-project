<?php 

namespace Hcode\Sql;

use Hcode\Collection;

class Tables extends Collection {
	
	protected $class = "Hcode\Sql\Table";
	protected $pk = "";

	public function get(){}

	public static function listAll(){

		$tables = new Tables();

		$tables->loadFromQuery("SHOW TABLE STATUS FROM ".DB_NAME.";");

		return $tables;

	}

}

?>