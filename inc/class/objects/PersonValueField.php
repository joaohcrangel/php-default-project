


<?php

class PersonValueField extends Model {

    public $required = array('idfield', 'desfield');
    protected $pk = "idfield";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_personsvaluesfields_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_personsvaluesfields_save(?, ?, ?);", array(
                $this->getidfield(),
                $this->getdesfield(),
                $this->getdtregister()
            ));

            return $this->getidfield();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_personsvaluesfields_remove", array(
            $this->getidfield()
        ));

        return true;
        
    }

}

?>