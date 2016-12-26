<?php

class PessoaTipo extends Model {

    public $required = array('despessoatipo');
    protected $pk = "idpessoatipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoastipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoastipos_save(?, ?);", array(
                $this->getidpessoatipo(),
                $this->getdespessoatipo()
            ));

            return $this->getidpessoatipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pessoastipos_remove(".$this->getidpessoatipo().")");

        return true;
        
    }

}

?>