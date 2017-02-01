<?php

class CupomTipo extends Model {

    public $required = array('idcupomtipo', 'descupomtipo');
    protected $pk = "idcupomtipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cuponstipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cuponstipos_save(?, ?);", array(
                $this->getidcupomtipo(),
                $this->getdescupomtipo()
            ));

            return $this->getidcupomtipo();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_cuponstipos_remove", array(
            $this->getidcupomtipo()
        ));

        return true;
        
    }

}

?>