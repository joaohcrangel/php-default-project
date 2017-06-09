


<?php

class EventsProperties extends Collection {

    protected $class = "EventPropertie";
    protected $saveQuery = "sp_eventsproperties_save";
    protected $saveArgs = array("idproperty", "desproperty", "dtregister");
    protected $pk = "idproperty";

    public function get(){}

}

?>