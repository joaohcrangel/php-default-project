<?php

namespace Hcode\Stand\Event;

use Hcode\Collection;

class Organizers extends Collection {

    protected $class = "Hcode\Stand\Event\Organizer";
    protected $saveQuery = "sp_eventsorganizers_save";
    protected $saveArgs = array("idorganizer", "desorganizer");
    protected $pk = "idorganizer";

    public function get(){}

}

?>