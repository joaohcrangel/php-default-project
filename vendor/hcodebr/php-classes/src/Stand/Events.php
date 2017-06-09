<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Events extends Collection {

    protected $class = "Hcode\Stand\Event";
    protected $saveQuery = "sp_events_save";
    protected $saveArgs = array("idevent", "desevent", "idfrequency", "idorganizer", "dtregister");
    protected $pk = "idevent";

    public function get(){}

}

?>