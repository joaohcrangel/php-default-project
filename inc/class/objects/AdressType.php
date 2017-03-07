


<?php

class AdressType extends Model {

    public $required = array('idadresstype', 'desadresstype');
    protected $pk = "idadresstype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_adressestypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_adressestypes_save(?, ?, ?);", array(
                $this->getidadresstype(),
                $this->getdesadresstype(),
                $this->getdtregister()
            ));

            return $this->getidadresstype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_adressestypes_remove", array(
            $this->getidadresstype()
        ));

        return true;
        
    }

}

?>