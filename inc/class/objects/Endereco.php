<?php

class Endereco extends Model {

    public $required = array('idenderecotipo', 'desendereco', 'desnumero', 'desbairro', 'descidade', 'desestado', 'despais', 'descep');
    protected $pk = "idendereco";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_enderecos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_enderecos_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidendereco(),
                $this->getidenderecotipo(),
                $this->getdesendereco(),
                $this->getdesnumero(),
                $this->getdesbairro(),
                $this->getdescidade(),
                $this->getdesestado(),
                $this->getdespais(),
                $this->getdescep(),
                $this->getdescomplemento()
            ));

            return $this->getidendereco();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_enderecos_remove(".$this->getidendereco().")");

        return true;
        
    }

}

?>