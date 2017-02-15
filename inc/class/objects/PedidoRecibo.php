<?php

class PedidoRecibo extends Model {

    public $required = array('idpedido', 'desautenticacao');
    protected $pk = "idpedido";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidosrecibos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidosrecibos_save(?, ?);", array(
                $this->getidpedido(),
                $this->getdesautenticacao()
            ));

            return $this->getidpedido();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pedidosrecibos_remove(".$this->getidpedido().")");

        return true;
        
    }

}

?>