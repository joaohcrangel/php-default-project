<?php

class CartaoCredito extends Model {

    public $required = array('idcartao', 'idpessoa', 'desnome', 'dtvalidade', 'nrcds', 'desnumero');
    protected $pk = "idcartao";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cartoesdecreditos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cartoesdecreditos_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcartao(),
                $this->getidpessoa(),
                $this->getdesnome(),
                $this->getdtvalidade(),
                $this->getnrcds(),
                $this->getdesnumero()
            ));

            return $this->getidcartao();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_cartoesdecreditos_remove(".$this->getidcartao().")");

        return true;
        
    }

}

?>