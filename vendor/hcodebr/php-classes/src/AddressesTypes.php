<?php

namespace Hcode;

class AddressesTypes extends Collection {

    protected $class = "AddressType";
    protected $saveQuery = "sp_addressestypes_save";
    protected $saveArgs = array("idaddresstype", "desaddresstype");
    protected $pk = "idaddresstype";

    public function get(){}

    public static function listAll():AddressesTypes
    {

      $col = new  AddressesTypes();

      $col->loadFromQuery("CALL sp_addressestypes_list()");

      return $col;

    }

}

?>