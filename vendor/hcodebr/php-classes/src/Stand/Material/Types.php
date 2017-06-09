<?php

namespace Hcode\Stand\Material;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Stand\Material\Type";
    protected $saveQuery = "sp_materialstypes_save";
    protected $saveArgs = array("idtype", "destype", "dtregister");
    protected $pk = "idtype";

    public function get(){}

}

?>