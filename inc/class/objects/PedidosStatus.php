<?php

class PedidosStatus extends Collection {

    protected $class = "PedidoStatus";
    protected $saveQuery = "sp_pedidosstatus_save";
    protected $saveArgs = array("idstatus", "desstatus");
    protected $pk = "idstatus";
    public function get(){}

    public static function listAll(){

    	$pedidos = new PedidosStatus();

    	$pedidos->loadFromQuery("CALL sp_pedidosstatus_list();");

    	return $pedidos;

    }

}

?>