<?php

class PagamentosProdutos extends Collection {

    protected $class = "PagamentoProduto";
    protected $saveQuery = "sp_pagamentosprodutos_save";
    protected $saveArgs = array("idpagamento", "idproduto", "nrqtd", "vlpreco", "vltotal");
    protected $pk = "idpagamento";
    public function get(){}

    public static function listAll(){

    	$pagamentos = new PagamentosProdutos();

    	$pagamentos->loadFromQuery("CALL sp_pagamentosprodutos_list();");

    	return $pagamentos;

    }

}

?>