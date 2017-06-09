<?php

namespace Hcode\Stand\Event;

use Hcode\Collection;

class Frequencies extends Collection {

    protected $class = "Hcode\Stand\Event\Frequency";
    protected $saveQuery = "sp_eventsfrequencies_save";
    protected $saveArgs = array("idfrequency", "desfrequency");
    protected $pk = "idfrequency";

    public function get(){}

}

?>