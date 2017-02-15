<?php

class PedidoStatus extends Model {

    public $required = array('idstatus', 'desstatus');
    protected $pk = "idstatus";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pedidosstatus_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pedidosstatus_save(?, ?);", array(
                $this->getidstatus(),
                $this->getdesstatus()
            ));

            return $this->getidstatus();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pedidosstatus_remove(".$this->getidstatus().")");

        return true;
        
    }

}

?>