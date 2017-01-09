<?php

class Pagamentos extends Collection {

    protected $class = "Pagamento";
    protected $saveQuery = "sp_pagamentos_save";
    protected $saveArgs = array("idpagamento", "idpessoa", "idformapagamento", "idstatus", "dessession", "vltotal", "nrparcelas");
    protected $pk = "idpagamento";
    public function get(){}

    public static function listAll(){

    	$pagamentos = new Pagamentos();

    	$pagamentos->loadFromQuery("CALL sp_pagamentos_list();");

    	return $pagamentos;

    }

}

?>