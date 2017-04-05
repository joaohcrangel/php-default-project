<?php

namespace Hcode;

class SettingsTypes extends Collection {

    protected $class = "SettingType";
    protected $saveQuery = "sp_settingstypes_save";
    protected $saveArgs = array("idsettingtype", "dessettingtype");
    protected $pk = "idsettingtype";

    public function get(){}

     public static function listAll(){
      $col = new  SettingsTypes();
      $col->loadFromQuery("call sp_settingstypes_list()");
      return $col;

    }

}

?>