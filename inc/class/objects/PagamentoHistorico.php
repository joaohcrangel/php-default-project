<?php

class PagamentoHistorico extends Model {

    public $required = array('idhistorico', 'idpagamento', 'idusuario');
    protected $pk = "idhistorico";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pagamentoshistoricos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pagamentoshistoricos_save(?, ?, ?);", array(
                $this->getidhistorico(),
                $this->getidpagamento(),
                $this->getidusuario()
            ));

            return $this->getidhistorico();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_pagamentoshistoricos_remove", array(
            $this->getidhistorico()
        ));

        return true;
        
    }

}

?>