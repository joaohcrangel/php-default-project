<?php

class PedidoProduto extends Model {

    public $required = array('idpedido', 'idproduto', 'nrqtd', 'vlpreco', 'vltotal');
    protected $pk = "idpedido";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidosprodutos_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidosprodutos_save(?, ?, ?, ?, ?);", array(
                $this->getidpedido(),
                $this->getidproduto(),
                $this->getnrqtd(),
                $this->getvlpreco(),
                $this->getvltotal()
            ));

            return $this->getidpedido();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pedidosprodutos_remove(".$this->getidpedido().", ".$this->getidproduto().")");

        return true;
        
    }

}

?>