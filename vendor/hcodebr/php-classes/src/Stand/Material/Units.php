<?php

namespace Hcode\Stand\Material;

use Hcode\Collection;

class Units extends Collection {

    protected $class = "Hcode\Stand\Material\Unit";
    protected $saveQuery = "sp_materialsunitstypes_save";
    protected $saveArgs = array("idunitytype", "desidunitytype", "dtregister");
    protected $pk = "idunitytype";

    public function get(){}

}

?>