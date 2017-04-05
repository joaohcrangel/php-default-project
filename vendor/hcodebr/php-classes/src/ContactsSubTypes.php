<?php

namespace Hcode;

class ContactsSubTypes extends Collection {

    protected $class = "Hcode\ContactSubType";
    protected $saveQuery = "sp_contactssubtypes_save";
    protected $saveArgs = array("idcontactsubtype", "descontactsubtype", "idcontacttype", "iduser");
    protected $pk = "idcontactsubtype";

    public function get(){}

    public static function listAll():ContactsSubTypes
    {

      $col = new  ContactsSubTypes();

      $col->loadFromQuery("CALL sp_contactssubtypes_list()");

      return $col;

    }

}

?>