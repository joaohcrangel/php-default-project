<?php

namespace Hcode;

class PersonsValuesFields extends Collection {

    protected $class = "Hcode\PersonValueField";
    protected $saveQuery = "sp_personsvaluesfields_save";
    protected $saveArgs = array("idfield", "desfield");
    protected $pk = "idfield";

    public function get(){}

    public static function listAll():PersonsValuesFields
    {

		$fields = new PersonsValuesFields();

		$fields->loadFromQuery("SELECT * FROM tb_personsvaluesfields;");

    	return $fields;

    }

}

?>