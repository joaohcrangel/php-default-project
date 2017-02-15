<?php

class PedidosProdutos extends Collection {

    protected $class = "PedidoProduto";
    protected $saveQuery = "sp_pedidosprodutos_save";
    protected $saveArgs = array("idpedido", "idproduto", "nrqtd", "vlpreco", "vltotal");
    protected $pk = "idpedido";
    public function get(){}

    public static function listAll(){

    	$pedidos = new PedidosProdutos();

    	$pedidos->loadFromQuery("CALL sp_pedidosprodutos_list();");

    	return $pedidos;

    }

}

?>