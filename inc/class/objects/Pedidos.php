<?php

class Pedidos extends Collection {

    protected $class = "Pedido";
    protected $saveQuery = "sp_pedidos_save";
    protected $saveArgs = array("idpedido", "idpessoa", "idformapedido", "idstatus", "dessession", "vltotal", "nrparcelas");
    protected $pk = "idpedido";
    public function get(){}

    public static function listAll(){

    	$pedidos = new Pedidos();

    	$pedidos->loadFromQuery("CALL sp_pedidos_list();");

    	return $pedidos;

    }

      public function getByPessoa(Pessoa $pessoa):Pedidos
      
    {
    
         $this->loadFromQuery("CALL sp_pedidosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
        ));

         return $this;

    }

}

?>