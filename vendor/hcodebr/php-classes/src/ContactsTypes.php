<?php

namespace Hcode;

class ContactsTypes extends Collection {

    protected $class = "Hcode\ContactType";
    protected $saveQuery = "sp_contactstypes_save";
    protected $saveArgs = array("idcontacttype", "descontacttype");
    protected $pk = "idcontacttype";

    public function get(){}

    public static function listAll():ContactsTypes
    {

    	$types = new ContactsTypes();

    	$types->loadFromQuery("CALL sp_contactstypes_list();");

    	return $types;

    }

}

?>