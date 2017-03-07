


<?php

class PersonValue extends Model {

    public $required = array('idpersonvalue', 'idperson', 'idfield', 'desvalue');
    protected $pk = "idpersonvalue";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personsvalues_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personsvalues_save(?, ?, ?, ?, ?);", array(
                $this->getidpersonvalue(),
                $this->getidperson(),
                $this->getidfield(),
                $this->getdesvalue(),
                $this->getdtregister()
            ));

            return $this->getidpersonvalue();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_personsvalues_remove", array(
            $this->getidpersonvalue()
        ));

        return true;
        
    }

}

?>