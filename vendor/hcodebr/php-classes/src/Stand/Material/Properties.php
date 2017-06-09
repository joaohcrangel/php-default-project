<?php

namespace Hcode\Stand\Material;

use Hcode\Collection;

class Properties extends Collection {

    protected $class = "Hcode\Stand\Material\Propertie";
    protected $saveQuery = "sp_materialsproperties_save";
    protected $saveArgs = array("idproperty", "desproperty", "dtregister");
    protected $pk = "idproperty";

    public function get(){}

}

?>