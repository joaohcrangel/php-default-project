<?php

class PagamentosStatus extends Collection {

    protected $class = "PagamentoStatus";
    protected $saveQuery = "sp_pagamentosstatus_save";
    protected $saveArgs = array("idstatus", "desstatus");
    protected $pk = "idstatus";
    public function get(){}

    public static function listAll(){

    	$pagamentos = new PagamentosStatus();

    	$pagamentos->loadFromQuery("CALL sp_pagamentosstatus_list();");

    	return $pagamentos;

    }

}

?>