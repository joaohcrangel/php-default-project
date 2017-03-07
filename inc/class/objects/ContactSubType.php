


<?php

class ContactSubType extends Model {

    public $required = array('idcontactsubtype', 'descontactsubtype', 'idcontacttype');
    protected $pk = "idcontactsubtype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contactssubtypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contactssubtypes_save(?, ?, ?, ?, ?);", array(
                $this->getidcontactsubtype(),
                $this->getdescontactsubtype(),
                $this->getidcontacttype(),
                $this->getiduser(),
                $this->getdtregister()
            ));

            return $this->getidcontactsubtype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_contactssubtypes_remove", array(
            $this->getidcontactsubtype()
        ));

        return true;
        
    }

}

?>