<?php

namespace Hcode;

class SitesContacts extends Collection {

    protected $class = "SiteContact";
    protected $saveQuery = "sp_sitescontacts_save";
    protected $saveArgs = array("idsitecontact", "idperson", "desmessage", "inread", "idpersonanswer");
    protected $pk = "idsitecontact";
    public function get(){}

    public static function listAll(){

    	$contacts = new SitesContacts();

    	$contacts->loadFromQuery("CALL sp_sitescontacts_list();");

    	return $contacts;

    }

      public function getByPerson(Person $person):SitesContacts      
    {
    
         $this->loadFromQuery("CALL sp_sitescontactsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }


}

?>