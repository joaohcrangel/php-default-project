


<?php

class ContactType extends Model {

    public $required = array('idcontacttype', 'descontacttype');
    protected $pk = "idcontacttype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contactstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contactstypes_save(?, ?, ?);", array(
                $this->getidcontacttype(),
                $this->getdescontacttype(),
                $this->getdtregister()
            ));

            return $this->getidcontacttype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_contactstypes_remove", array(
            $this->getidcontacttype()
        ));

        return true;
        
    }

}

?>