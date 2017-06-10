<?php

namespace Hcode\Stand\Event;

use Hcode\Collection;

class Properties extends Collection {

    protected $class = "Hcode\Stand\Event\Propertie";
    protected $saveQuery = "sp_eventsproperties_save";
    protected $saveArgs = array("idproperty", "desproperty");
    protected $pk = "idproperty";

    public function get(){}

}

?>