<?php

class PedidosNegociacoesTipos extends Collection {

    protected $class = "PedidoNegociacaoTipo";
    protected $saveQuery = "sp_pedidosnegociacoestipos_save";
    protected $saveArgs = array("idnegociacao", "desnegociacao");
    protected $pk = "idnegociacao";

    public function get(){}

}

?>