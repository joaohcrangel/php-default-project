<?php

namespace Hcode\Stand\Material\Propertie;

use Hcode\Collection;

class Values extends Collection {

    protected $class = "Hcode\Stand\Material\Propertie\Value";
    protected $saveQuery = "sp_materialspropertiesvalues_save";
    protected $saveArgs = array("idmaterial", "idproperty", "desvalue", "dtregister");
    protected $pk = array(idmaterial, idproperty);

    public function get(){}

}

?>