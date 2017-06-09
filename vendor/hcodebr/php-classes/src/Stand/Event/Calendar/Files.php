


<?php

class EventsCalendarsFiles extends Collection {

    protected $class = "EventCalendarFile";
    protected $saveQuery = "sp_eventscalendarsfiles_save";
    protected $saveArgs = array("idcalendar", "idfile", "dtregister");
    protected $pk = array(idcalendar, idfile);

    public function get(){}

}

?>