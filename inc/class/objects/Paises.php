<?php

class Paises extends Collection {

    protected $class = "Pais";
    protected $saveQuery = "sp_paises_save";
    protected $saveArgs = array("idpais", "despais");
    protected $pk = "idpais";

    public function get(){}

    public static function listAll():Paises
    {

    	$paises = new Paises();

    	$paises->loadFromQuery("CALL sp_paises_list();");

    	return $paises;

    }

}

?>