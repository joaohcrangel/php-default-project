


<?php

class EventsCalendarsDays extends Collection {

    protected $class = "EventCalendarDay";
    protected $saveQuery = "sp_eventscalendarsdays_save";
    protected $saveArgs = array("idday", "idcalendar", "dtstart", "dtend", "inevent", "dtregister");
    protected $pk = "idday";

    public function get(){}

}

?>