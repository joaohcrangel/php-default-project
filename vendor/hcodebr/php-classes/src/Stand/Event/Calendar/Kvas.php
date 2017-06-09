<?php

class EventsCalendarsKvas extends Collection {

    protected $class = "EventCalendarKva";
    protected $saveQuery = "sp_eventscalendarskvas_save";
    protected $saveArgs = array("idcalendar", "idmaterial", "vlkva", "dtregister");
    protected $pk = array(idcalendar, idmaterial);

    public function get(){}

}

?>