<?php

class PagamentoRecibo extends Model {

    public $required = array('idpagamento', 'desautenticacao');
    protected $pk = "idpagamento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pagamentosrecibos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pagamentosrecibos_save(?, ?);", array(
                $this->getidpagamento(),
                $this->getdesautenticacao()
            ));

            return $this->getidpagamento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pagamentosrecibos_remove(".$this->getidpagamento().")");

        return true;
        
    }

}

?>