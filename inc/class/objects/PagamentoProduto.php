<?php

class PagamentoProduto extends Model {

    public $required = array('idpagamento', 'idproduto', 'nrqtd', 'vlpreco', 'vltotal');
    protected $pk = "idpagamento";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pagamentosprodutos_get(".$args[0].", ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pagamentosprodutos_save(?, ?, ?, ?, ?);", array(
                $this->getidpagamento(),
                $this->getidproduto(),
                $this->getnrqtd(),
                $this->getvlpreco(),
                $this->getvltotal()
            ));

            return $this->getidpagamento();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pagamentosprodutos_remove(".$this->getidpagamento().", ".$this->getidproduto().")");

        return true;
        
    }

}

?>