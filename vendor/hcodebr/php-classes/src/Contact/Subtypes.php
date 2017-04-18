<?php

namespace Hcode\Contact;

use Hcode\Collection;
use Hcode\Exception;

class Subtypes extends Collection {

    protected $class = "Hcode\Contact\SubType";
    protected $saveQuery = "sp_contactssubtypes_save";
    protected $saveArgs = array("idcontactsubtype", "descontactsubtype", "idcontacttype", "iduser");
    protected $pk = "idcontactsubtype";

    public function get(){}

    public static function listAll():Subtypes
    {

      $col = new Subtypes();

      $col->loadFromQuery("CALL sp_contactssubtypes_list()");

      return $col;

    }

}

?>