


<?php

class ContactsSubTypes extends Collection {

    protected $class = "ContactSubType";
    protected $saveQuery = "sp_contactssubtypes_save";
    protected $saveArgs = array("idcontactsubtype", "descontactsubtype", "idcontacttype", "iduser", "dtregister");
    protected $pk = "idcontactsubtype";

    public function get(){}

}

?>