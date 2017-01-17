<?php

class Pagamento extends Model {

    public $required = array('idpagamento', 'idpessoa', 'idformapagamento', 'idstatus', 'dessession', 'vltotal', 'nrparcelas');
    protected $pk = "idpagamento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pagamentos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pagamentos_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidpagamento(),
                $this->getidpessoa(),
                $this->getidformapagamento(),
                $this->getidstatus(),
                $this->getdessession(),
                $this->getvltotal(),
                $this->getnrparcelas()
            ));

            return $this->getidpagamento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pagamentos_remove(".$this->getidpagamento().")");

        return true;
        
    }

}

?>