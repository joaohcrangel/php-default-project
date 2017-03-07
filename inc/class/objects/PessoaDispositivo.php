<?php

class PessoaDispositivo extends Model {

    public $required = array('idpessoa', 'desdispositivo', 'desid', 'dessistema');
    protected $pk = "iddispositivo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoasdispositivos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoasdispositivos_save(?, ?, ?, ?, ?);", array(
                $this->getiddispositivo(),
                $this->getidpessoa(),
                $this->getdesdispositivo(),
                $this->getdesid(),
                $this->getdessistema()
            ));

            return $this->getiddispositivo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_pessoasdispositivos_remove", array(
            $this->getiddispositivo()
        ));

        return true;
        
    }

}

?>