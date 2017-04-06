<?php

namespace Hcode\Sites;

use \Hcode\Collection;
use \Hcode\Person;

class Contacts extends Collection {

    protected $class = "Hcode\Site\Contact";
    protected $saveQuery = "sp_sitescontacts_save";
    protected $saveArgs = array("idsitecontact", "idperson", "desmessage", "inread", "idpersonanswer");
    protected $pk = "idsitecontact";
    public function get(){}

    public static function listAll(){

    	$contacts = new Contacts();

    	$contacts->loadFromQuery("CALL sp_sitescontacts_list();");

    	return $contacts;

    }

      public function getByPerson(Person $person):Contacts      
    {
    
         $this->loadFromQuery("CALL sp_sitescontactsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }


}

?>