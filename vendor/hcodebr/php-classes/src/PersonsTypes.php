<?php

namespace Hcode;

class PersonsTypes extends Collection {

    protected $class = "PersonType";
    protected $saveQuery = "sp_personstypes_save";
    protected $saveArgs = array("idpersontype", "despersontype");
    protected $pk = "idpersontype";

    public function get(){}

     public static function listAll():PersonsTypes
     {

		$personstypes = new PersonsTypes();

		$personstypes->loadFromQuery("SELECT * FROM tb_personstypes");

    	return $personstypes;

    }

}

?>