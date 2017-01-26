<?php

class Pessoa extends Model {

    public $required = array('despessoa', 'idpessoatipo');
    protected $pk = "idpessoa";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoas_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoas_save(?, ?, ?);", array(
                $this->getidpessoa(),
                $this->getdespessoa(),
                $this->getidpessoatipo()
            ));

            return $this->getidpessoa();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_pessoas_remove(".$this->getidpessoa().")");

        return true;
        
    }
    public function getContatos(){

        return new Contatos($this);
    }
    public function getHistoricos(){

        return new PessoasHistoricos($this);
    }

    

}

?>