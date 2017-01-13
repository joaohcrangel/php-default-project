<?php

class Documentos extends Collection {

    protected $class = "Documento";
    protected $saveQuery = "sp_documentos_save";
    protected $saveArgs = array("iddocumento", "iddocumentotipo", "idpessoa", "desdocumento");
    protected $pk = "iddocumento";

    public function get(){}

    public static function listTipos(){

    	$tipos = new Documentos();

    	$tipos->loadFromQuery("CALL sp_documentostipos_list();");

    	return $tipos;

    }

    public static function listFromPessoa($idpessoa){

    	$documentos = new Documentos();

    	$documentos->loadFromQuery("CALL sp_documentosfrompessoa_list(?)", array(
    		(int)$idpessoa
    	));

    	return $documentos;

    }

}

?>