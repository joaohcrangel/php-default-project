<?php

namespace Hcode\Person;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Person\Type";
    protected $saveQuery = "sp_personstypes_save";
    protected $saveArgs = array("idpersontype", "despersontype");
    protected $pk = "idpersontype";

    public function get(){}

    public static function listAll():Types
    {

		$personstypes = new Types();

		$personstypes->loadFromQuery("SELECT * FROM tb_personstypes");

    	return $personstypes;

    }

}

?>