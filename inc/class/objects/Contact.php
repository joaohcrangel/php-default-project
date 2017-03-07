


<?php

class Contact extends Model {

    public $required = array('idcontact', 'idcontactsubtype', 'idperson', 'descontact', 'inprincipal');
    protected $pk = "idcontact";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contacts_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contacts_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidcontact(),
                $this->getidcontactsubtype(),
                $this->getidperson(),
                $this->getdescontact(),
                $this->getinprincipal(),
                $this->getdtregister()
            ));

            return $this->getidcontact();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_contacts_remove", array(
            $this->getidcontact()
        ));

        return true;
        
    }

}

?>