<?php

namespace Hcode\Address;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Address\Type";
    protected $saveQuery = "sp_addressestypes_save";
    protected $saveArgs = array("idaddresstype", "desaddresstype");
    protected $pk = "idaddresstype";

    public function get(){}

    public static function listAll():Types
    {

      $col = new Types();

      $col->loadFromQuery("CALL sp_addressestypes_list()");

      return $col;

    }

}

?>