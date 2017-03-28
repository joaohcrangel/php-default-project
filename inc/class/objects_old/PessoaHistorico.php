<?php

class PessoaHistorico extends Model {

    public $required = array('idpessoa', 'idhistoricotipo', 'deshistorico');
    protected $pk = "idpessoahistorico";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoashistoricos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoashistoricos_save(?, ?, ?, ?);", array(
                $this->getidpessoahistorico(),
                $this->getidpessoa(),
                $this->getidhistoricotipo(),
                $this->getdeshistorico()
            ));

            return $this->getidpessoahistorico();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_pessoashistoricos_remove", array(
            $this->getidpessoahistorico()
        ));

        return true;
        
    }

}

?>