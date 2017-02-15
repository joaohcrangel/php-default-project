<?php

class Pedido extends Model {

    public $required = array('idpedido', 'idpessoa', 'idformapedido', 'idstatus', 'dessession', 'vltotal', 'nrparcelas');
    protected $pk = "idpedido";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidos_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidpedido(),
                $this->getidpessoa(),
                $this->getidformapedido(),
                $this->getidstatus(),
                $this->getdessession(),
                $this->getvltotal(),
                $this->getnrparcelas()
            ));

            return $this->getidpedido();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pedidos_remove(".$this->getidpedido().")");

        return true;
        
    }

    public function getRecibos(){

        $recibos = new Pedidos();

        $recibos->loadFromQuery("CALL sp_recibosfrompedido_list(?);", array(
            $this->getidpedido()
        ));

        return $recibos;

    }

}

?>