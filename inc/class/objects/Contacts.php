


<?php

class Contacts extends Collection {

    protected $class = "Contact";
    protected $saveQuery = "sp_contacts_save";
    protected $saveArgs = array("idcontact", "idcontactsubtype", "idperson", "descontact", "inprincipal", "dtregister");
    protected $pk = "idcontact";

    public function get(){}

}

?>