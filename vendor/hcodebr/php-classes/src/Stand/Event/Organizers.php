


<?php

class EventsOrganizers extends Collection {

    protected $class = "EventOrganizer";
    protected $saveQuery = "sp_eventsorganizers_save";
    protected $saveArgs = array("idorganizer", "desorganizer", "dtregister");
    protected $pk = "idorganizer";

    public function get(){}

}

?>