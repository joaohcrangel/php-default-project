<?php

class Requests extends Collection {

    protected $class = "Request";
    protected $saveQuery = "sp_requests_save";
    protected $saveArgs = array("idrequest", "idperson", "idformrequest", "idstatus", "dessession", "vltotal", "nrplots");
    protected $pk = "idrequest";
    public function get(){}

    public static function listAll(){

    	$requests = new Requests();

    	$requests->loadFromQuery("CALL sp_requests_list();");

    	return $requests;

    }

      public function getByPerson(Person $person):Requests
      
    {
    
         $this->loadFromQuery("CALL sp_requestsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

}

?>