<?php

class EventsCalendars extends Collection {

    protected $class = "EventCalendar";
    protected $saveQuery = "sp_eventscalendars_save";
    protected $saveArgs = array("idcalendar", "idevent", "idplace", "dtstart", "dtend", "desurl", "dtregister");
    protected $pk = "idcalendar";

    public function get(){}

}

?>