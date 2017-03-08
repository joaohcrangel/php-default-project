<?php

class AdressesTypes extends Collection {

    protected $class = "AdressType";
    protected $saveQuery = "sp_adressestypes_save";
    protected $saveArgs = array("idadresstype", "desadresstype");
    protected $pk = "idadresstype";

    public function get(){}

    public static function listAll():AdressesTypes
    {

      $col = new  AdressesTypes();

      $col->loadFromQuery("call sp_adressestypes_list()");

      return $col;

    }

}

?>