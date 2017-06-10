<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Materials extends Collection {

    protected $class = "Hcode\Stand\Material";
    protected $saveQuery = "sp_materials_save";
    protected $saveArgs = array("idmaterial", "idmaterialparent", "idmaterialtype", "idunitytype", "idphoto", "desmaterial", "descode", "inreusable", "dtregister");
    protected $pk = "idmaterial";

    public function get(){}

}

?>