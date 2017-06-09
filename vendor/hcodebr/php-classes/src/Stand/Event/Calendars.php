<?php

namespace Hcode\Stand\Event;

use Hcode\Collection;

class Calendars extends Collection {

    protected $class = "Hcode\Stand\Event\Calendar";
    protected $saveQuery = "sp_eventscalendars_save";
    protected $saveArgs = array("idcalendar", "idevent", "idplace", "dtstart", "dtend", "desurl");
    protected $pk = "idcalendar";

    public function get(){}

}

?>