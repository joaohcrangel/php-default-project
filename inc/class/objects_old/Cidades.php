<?php

class Cidades extends Collection {

    protected $class = "Cidade";
    protected $saveQuery = "sp_cidades_save";
    protected $saveArgs = array("idcidade", "descidade", "idestado");
    protected $pk = "idcidade";

    public function get(){}

    public static function listAll():Cidades
    {

    	$cidades = new Cidades();

    	$cidades->loadFromQuery("CALL sp_cidades_list();");

    	return $cidades;

    }

}

?>