


<?php

class ContactsTypes extends Collection {

    protected $class = "ContactType";
    protected $saveQuery = "sp_contactstypes_save";
    protected $saveArgs = array("idcontacttype", "descontacttype", "dtregister");
    protected $pk = "idcontacttype";

    public function get(){}

}

?>