<?php

class EnderecoTipo extends Model {

    public $required = array('desenderecotipo');
    protected $pk = "idenderecotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_enderecostipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_enderecostipos_save(?, ?);", array(
                $this->getidenderecotipo(),
                $this->getdesenderecotipo()
            ));

            return $this->getidenderecotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_enderecostipos_remove(".$this->getidenderecotipo().")");

        return true;
        
    }

}

?>