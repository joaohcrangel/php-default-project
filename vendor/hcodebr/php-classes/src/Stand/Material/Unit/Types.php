<?php

namespace Hcode\Stand\Material\Unit;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Stand\Material\Unit\Type";
    protected $saveQuery = "sp_materialsunitstypes_save";
    protected $saveArgs = array("idunitytype", "desunitytype", "desunitytypeshort", "dtregister");
    protected $pk = "idunitytype";

    public function get(){}

}

?>