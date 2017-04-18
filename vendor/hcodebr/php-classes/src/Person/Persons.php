<?php

namespace Hcode\Person;

use Hcode\Collection;

class Persons extends Collection {

    protected $class = "Hcode\Person\Person";
    protected $saveQuery = "sp_persons_save";
    protected $saveArgs = array("idperson", "idpersontype", "desperson", "dtbirth", "dessex", "desphoto", "desemail", "desphone", "descpf", "desrg", "descnpj");
    protected $pk = "idperson";

    public function get(){}

    public static function listAll():Persons
    {

    	$persons = new Persons();

    	$persons->loadFromQuery("CALL sp_persons_list();");

    	return $persons;

    }

}

?>