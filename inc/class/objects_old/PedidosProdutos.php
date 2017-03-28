<?php

class RequestsProducts extends Collection {

    protected $class = "RequestProduct";
    protected $saveQuery = "sp_requestsproducts_save";
    protected $saveArgs = array("idrequest", "idproduct", "nrqtd", "vlprice", "vltotal");
    protected $pk = "idrequest";
    public function get(){}

    public static function listAll(){

    	$requests = new PedidosProdutos();

    	$requests->loadFromQuery("CALL sp_requestsproducts_list();");

    	return $requests;

    }

}

?>