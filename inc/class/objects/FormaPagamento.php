<?php

class FormaPagamento extends Model {

    public $required = array('idformapagamento', 'idgateway', 'desformapagamento', 'nrparcelasmax', 'instatus');
    protected $pk = "idformapagamento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_formaspagamentos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_formaspagamentos_save(?, ?, ?, ?, ?);", array(
                $this->getidformapagamento(),
                $this->getidgateway(),
                $this->getdesformapagamento(),
                $this->getnrparcelasmax(),
                $this->getinstatus()
            ));

            return $this->getidformapagamento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_formaspagamentos_remove(".$this->getidformapagamento().")");

        return true;
        
    }

}

?>