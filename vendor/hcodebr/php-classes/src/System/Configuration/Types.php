<?php

namespace Hcode\System\Configuration;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\System\Configuration\Type";
    protected $saveQuery = "sp_configurationstypes_save";
    protected $saveArgs = array("idconfigurationtype", "desconfigurationtype");
    protected $pk = "idconfigurationtype";

    public function get(){}

     public static function listAll(){
      $col = new Types();
      $col->loadFromQuery("call sp_configurationstypes_list()");
      return $col;

    }

}

?>