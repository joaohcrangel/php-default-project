


<?php

class EventsPartners extends Collection {

    protected $class = "EventPartner";
    protected $saveQuery = "sp_eventspartners_save";
    protected $saveArgs = array("idcalendar", "idperson", "dtregister");
    protected $pk = array(idcalendar, idperson);

    public function get(){}

}

?>