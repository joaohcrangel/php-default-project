<?php

class PagamentosHistoricos extends Collection {

    protected $class = "PagamentoHistorico";
    protected $saveQuery = "sp_pagamentoshistoricos_save";
    protected $saveArgs = array("idhistorico", "idpagamento", "idusuario");
    protected $pk = "idhistorico";

    public function get(){}

    public static function listAll():PagamentosHistoricos
    {

    	$historicos = new PagamentosHistoricos();

    	$historicos->loadFromQuery("CALL sp_pagamentoshistoricos_list();");

    	return $historicos;

    }

}

?>