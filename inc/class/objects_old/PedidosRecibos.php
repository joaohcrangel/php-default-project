<?php

class PedidosRecibos extends Collection {

    protected $class = "PedidoRecibo";
    protected $saveQuery = "sp_pedidosrecibos_save";
    protected $saveArgs = array("idpedido", "desautenticacao");
    protected $pk = "idpedido";
    public function get(){}

    public static function listAll(){

    	$pedidos = new PedidosRecibos();

    	$pedidos->loadFromQuery("CALL sp_pedidosrecibos_list();");

    	return $pedidos;

    }

}

?>