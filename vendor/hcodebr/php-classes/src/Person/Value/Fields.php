<?php

namespace Hcode\Person\Value;

use Hcode\Collection;

class Fields extends Collection {

    protected $class = "Hcode\Person\Value\Field";
    protected $saveQuery = "sp_personsvaluesfields_save";
    protected $saveArgs = array("idfield", "desfield");
    protected $pk = "idfield";

    public function get(){}

    public static function listAll():Fields
    {

		$fields = new Fields();

		$fields->loadFromQuery("SELECT * FROM tb_personsvaluesfields;");

    	return $fields;

    }

}

?>