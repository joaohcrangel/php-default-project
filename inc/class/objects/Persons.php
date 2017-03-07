<?php

class Persons extends Collection {

    protected $class = "Person";
    protected $saveQuery = "sp_persons_save";
    protected $saveArgs = array("idperson", "idpersontype", "desperson", "inremoved");
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