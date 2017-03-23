<?php

class CuponsTipos extends Collection {

    protected $class = "CupomTipo";
    protected $saveQuery = "sp_cuponstipos_save";
    protected $saveArgs = array("idcupomtipo", "descupomtipo");
    protected $pk = "idcupomtipo";

    public function get(){}

    public static function listAll():CuponsTipos
    {

    	$tipos = new CuponsTipos();

    	$tipos->loadFromQuery("CALL sp_cuponstipos_list();");

    	return $tipos;

    }

}

?>