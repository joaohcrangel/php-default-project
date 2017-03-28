<?php

class ConfiguracaoTipo extends Model {

    const STRING = 1;
    const INT = 2;
    const FLOAT = 3;
    const BOOL = 4;
    const DATETIME = 5;
    const ARRAY = 6;

    public $required = array('desconfiguracaotipo');
    protected $pk = "idconfiguracaotipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_configuracoestipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_configuracoestipos_save(?, ?);", array(
                $this->getidconfiguracaotipo(),
                $this->getdesconfiguracaotipo()
            ));

            return $this->getidconfiguracaotipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_configuracoestipos_remove", array(
            $this->getidconfiguracaotipo()
        ));

        return true;
        
    }

}

?>