<?php

class FormasPagamentos extends Collection {

    protected $class = "FormaPagamento";
    protected $saveQuery = "sp_formaspagamentos_save";
    protected $saveArgs = array("idformapagamento", "idgateway", "desformapagamento", "nrparcelasmax", "instatus");
    protected $pk = "idformapagamento";
    public function get(){}

    public static function listAll(){

    	$formas = new FormasPagamentos();

    	$formas->loadFromQuery("CALL sp_formaspagamentos_list();");

    	return $formas;

    }

}

?>