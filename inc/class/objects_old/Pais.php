<?php

class Pais extends Model {

    public $required = array('idpais', 'despais');
    protected $pk = "idpais";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_paises_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_paises_save(?, ?);", array(
                $this->getidpais(),
                $this->getdespais()
            ));

            return $this->getidpais();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_paises_remove", array(
            $this->getidpais()
        ));

        return true;
        
    }

}

?>