<?php

class Events extends Collection {

    protected $class = "Event";
    protected $saveQuery = "sp_events_save";
    protected $saveArgs = array("idevent", "desevent", "idfrequency", "nrfrequency", "idorganizer");
    protected $pk = "idevent";

    public function get(){}

}

?>