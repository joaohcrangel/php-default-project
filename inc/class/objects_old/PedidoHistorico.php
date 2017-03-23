<?php

class PedidoHistorico extends Model {

    public $required = array('idhistorico', 'idpedido', 'idusuario');
    protected $pk = "idhistorico";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidoshistoricos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidoshistoricos_save(?, ?, ?);", array(
                $this->getidhistorico(),
                $this->getidpedido(),
                $this->getidusuario()
            ));

            return $this->getidhistorico();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_pedidoshistoricos_remove", array(
            $this->getidhistorico()
        ));

        return true;
        
    }

}

?>