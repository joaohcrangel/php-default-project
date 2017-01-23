<?php

class LugaresTipos extends Collection {

    protected $class = "LugarTipo";
    protected $saveQuery = "sp_lugarestipos_save";
    protected $saveArgs = array("idlugartipo", "deslugartipo");
    protected $pk = "idlugartipo";
    public function get(){}

    public static function listAll(){

    	$tipos = new LugaresTipos();

    	$tipos->loadFromQuery("CALL sp_lugarestipos_list();");

    	return $tipos;

    }

}

?>