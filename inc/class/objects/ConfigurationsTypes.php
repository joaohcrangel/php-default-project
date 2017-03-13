<?php

class ConfigurationsTypes extends Collection {

    protected $class = "ConfigurationType";
    protected $saveQuery = "sp_configurationstypes_save";
    protected $saveArgs = array("idconfigurationtype", "desconfigurationtype");
    protected $pk = "idconfigurationtype";

    public function get(){}

     public static function listAll(){
      $col = new  ConfigurationsTypes();
      $col->loadFromQuery("call sp_configurationstypes_list()");
      return $col;

    }

}

?>