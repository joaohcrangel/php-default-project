<?php

class PagamentosRecibos extends Collection {

    protected $class = "PagamentoRecibo";
    protected $saveQuery = "sp_pagamentosrecibos_save";
    protected $saveArgs = array("idpagamento", "desautenticacao");
    protected $pk = "idpagamento";
    public function get(){}

    public static function listAll(){

    	$pagamentos = new PagamentosRecibos();

    	$pagamentos->loadFromQuery("CALL sp_pagamentosrecibos_list();");

    	return $pagamentos;

    }

}

?>