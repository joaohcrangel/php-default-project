<?php

namespace Hcode;

class PersonsDevices extends Collection {

    protected $class = "Hcode\PersonDevice";
    protected $saveQuery = "sp_personsdevices_save";
    protected $saveArgs = array("iddevice", "idperson", "desdevice", "desid", "dessystem");
    protected $pk = "iddevice";

    public function get(){}

}

?>