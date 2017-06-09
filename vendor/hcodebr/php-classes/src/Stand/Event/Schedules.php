


<?php

class EventsSchedulesValues extends Collection {

    protected $class = "EventScheduleValue";
    protected $saveQuery = "sp_eventsschedulesvalues_save";
    protected $saveArgs = array("idcalendar", "idproperty", "desvalue", "dtregister");
    protected $pk = array(idcalendar, idproperty);

    public function get(){}

}

?>