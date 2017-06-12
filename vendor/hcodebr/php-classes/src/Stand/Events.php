<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Events extends Collection {

    protected $class = "Hcode\Stand\Event";
    protected $saveQuery = "sp_events_save";
    protected $saveArgs = array("idevent", "desevent", "idfrequency", "nrfrequency", "idorganizer");
    protected $pk = "idevent";

    public function get(){}

    public static function listAll(){

    	$events = new Events();

    	$events->loadFromQuery("CALL sp_events_list();");

    	return $events;

    }

}

?>