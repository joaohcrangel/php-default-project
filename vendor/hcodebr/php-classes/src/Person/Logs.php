<?php

namespace Hcode\Person;

use Hcode\Collection;
use Hcode\Person\Person;

class Logs extends Collection {

    protected $class = "Hcode\Person\Log";
    protected $saveQuery = "sp_personslogs_save";
    protected $saveArgs = array("idpersonlog", "idperson", "idlogtype", "deslog");
    protected $pk = "idpersonlog";

    public function get(){}

    public function getByPerson(Person $person):Logs
    {
    
     	$this->loadFromQuery("CALL sp_personslogs_list(?)",array(
               $person->getidperson()
               
            ));

     	return $this;

    }

}

?>