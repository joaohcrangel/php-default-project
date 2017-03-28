<?php

class PedidosHistoricos extends Collection {

    protected $class = "PedidoHistorico";
    protected $saveQuery = "sp_pedidoshistoricos_save";
    protected $saveArgs = array("idhistorico", "idpedido", "idusuario");
    protected $pk = "idhistorico";

    public function get(){}

    public static function listAll():PedidosHistoricos
    {

    	$historicos = new PedidosHistoricos();

    	$historicos->loadFromQuery("CALL sp_pedidoshistoricos_list();");

    	return $historicos;

    }

}

?>