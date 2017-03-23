<?php

class PessoaCategoriaTipo extends Model {

    public $required = array('descategoria');
    protected $pk = "idcategoria";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_pessoascategoriastipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_pessoascategoriastipos_save(?, ?);", array(
                $this->getidcategoria(),
                $this->getdescategoria()
            ));

            return $this->getidcategoria();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_pessoascategoriastipos_remove", array(
            $this->getidcategoria()
        ));

        return true;
        
    }

}

?>