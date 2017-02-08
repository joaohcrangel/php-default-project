<?php

class LugarTipo extends Model {

    public $required = array('deslugartipo');
    protected $pk = "idlugartipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_lugarestipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_lugarestipos_save(?, ?);", array(
                $this->getidlugartipo(),
                $this->getdeslugartipo()
            ));

            return $this->getidlugartipo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_lugarestipos_remove(".$this->getidlugartipo().")");

        return true;
        
    }

}

?>