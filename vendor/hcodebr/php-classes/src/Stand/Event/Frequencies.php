


<?php

class EventsFrequencies extends Collection {

    protected $class = "EventFrequencie";
    protected $saveQuery = "sp_eventsfrequencies_save";
    protected $saveArgs = array("idfrequency", "desfrequency", "dtregister");
    protected $pk = "idfrequency";

    public function get(){}

}

?>