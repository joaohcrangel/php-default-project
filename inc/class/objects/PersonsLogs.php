<?php

class PersonsLogs extends Collection {

    protected $class = "PersonLog";
    protected $saveQuery = "sp_personslogs_save";
    protected $saveArgs = array("idpersonlog", "idperson", "idlogtype", "deslog");
    protected $pk = "idpersonlog";

    public function get(){}

    public function getByPessoa(Person $person){
    
     	$this->loadFromQuery("CALL sp_personslogs_list(?)",array(
               $person->getidperson()
               
            ));

     	return $this;

    }

}

?>