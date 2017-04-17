<?php

namespace Hcode;

use Hcode\Collection;

class Devices extends Collection {

    protected $class = "Hcode\Person\Device";
    protected $saveQuery = "sp_personsdevices_save";
    protected $saveArgs = array("iddevice", "idperson", "desdevice", "desid", "dessystem");
    protected $pk = "iddevice";

    public function get(){}

}

?>