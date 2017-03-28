<?php

class PedidosNegociacoesTipos extends Collection {

    protected $class = "PedidoNegociacaoTipo";
    protected $saveQuery = "sp_pedidosnegociacoestipos_save";
    protected $saveArgs = array("idnegociacao", "desnegociacao");
    protected $pk = "idnegociacao";

    public function get(){}

      public static function listAll():PedidosNegociacoesTipos
    {

    	$pedido = new PedidosNegociacoesTipos();

    	$pedido->loadFromQuery("CALL sp_pedidosnegociacoestipos_list();");

    	return $pedido;

    }

}

?>