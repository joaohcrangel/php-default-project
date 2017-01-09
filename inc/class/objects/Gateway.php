<?php

class Gateway extends Model {

    public $required = array('idgateway', 'desgateway');
    protected $pk = "idgateway";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_gateways_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_gateways_save(?, ?);", array(
                $this->getidgateway(),
                $this->getdesgateway()
            ));

            return $this->getidgateway();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_gateways_remove(".$this->getidgateway().")");

        return true;
        
    }

}

?>