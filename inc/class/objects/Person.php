


<?php

class Person extends Model {

    public $required = array('idperson', 'idpersontype', 'desperson');
    protected $pk = "idperson";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_persons_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_persons_save(?, ?, ?, ?, ?);", array(
                $this->getidperson(),
                $this->getidpersontype(),
                $this->getdesperson(),
                $this->getinremoved(),
                $this->getdtregister()
            ));

            return $this->getidperson();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_persons_remove", array(
            $this->getidperson()
        ));

        return true;
        
    }

}

?>