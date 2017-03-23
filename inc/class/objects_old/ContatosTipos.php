<?php

class ContatosTipos extends Collection {

    protected $class = "ContatoTipo";
    protected $saveQuery = "sp_contatostipos_save";
    protected $saveArgs = array("idcontatotipo", "descontatotipo");
    protected $pk = "idcontatotipo";

    public function get(){}

    public static function listAll(){

    	$tipos = new ContatosTipos();

    	$tipos->loadFromQuery("CALL sp_contatostipos_list();");

    	return $tipos;

    }

}

?>