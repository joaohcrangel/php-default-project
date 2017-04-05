<?php

namespace Hcode;

class PersonsLogs extends Collection {

    protected $class = "PersonLog";
    protected $saveQuery = "sp_personslogs_save";
    protected $saveArgs = array("idpersonlog", "idperson", "idlogtype", "deslog");
    protected $pk = "idpersonlog";

    public function get(){}

    public function getByPerson(Person $person):PersonsLogs
    {
    
     	$this->loadFromQuery("CALL sp_personslogs_list(?)",array(
               $person->getidperson()
               
            ));

     	return $this;

    }

}

?>