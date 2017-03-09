<?php

class SettingType extends Model {

    const STRING = 1;
    const INT = 2;
    const FLOAT = 3;
    const BOOL = 4;
    const DATETIME = 5;
    const ARRAY = 6;

    public $required = array('dessettingtype');
    protected $pk = "idsettingtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_settingstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_settingstypes_save(?, ?);", array(
                $this->getidsettingtype(),
                $this->getdessettingtype()
            ));

            return $this->getidsettingtype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_settingstypes_remove", array(
            $this->getidsettingtype()
        ));

        return true;
        
    }

}

?>