


<?php

class PersonType extends Model {

    public $required = array('idpersontype', 'despersontype');
    protected $pk = "idpersontype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personstypes_save(?, ?, ?);", array(
                $this->getidpersontype(),
                $this->getdespersontype(),
                $this->getdtregister()
            ));

            return $this->getidpersontype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_personstypes_remove", array(
            $this->getidpersontype()
        ));

        return true;
        
    }

}

?>