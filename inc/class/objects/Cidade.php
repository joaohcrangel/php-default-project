<?php

class Cidade extends Model {

    public $required = array('descidade', 'idestado');

    protected $pk = "idcidade";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cidades_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cidades_save(?, ?, ?);", array(
                $this->getidcidade(),
                $this->getdescidade(),
                $this->getidestado()
            ));

            return $this->getidcidade();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_cidades_remove", array(
            $this->getidcidade()
        ));

        return true;
        
    }

}

?>