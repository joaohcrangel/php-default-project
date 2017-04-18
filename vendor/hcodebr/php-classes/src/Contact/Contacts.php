<?php

namespace Hcode\Contact;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Persons;
use Hcode\Person;
use Hcode\Contacts;

class Contacts extends Collection {

    protected $class = "Hcode\Contact\Contact";
    protected $saveQuery = "sp_contacts_save";
    protected $saveArgs = array("idcontact", "idcontactsubtype", "idperson", "descontact", "inprincipal");
    protected $pk = "idcontact";

    public function get(){}

    public static function listAll():Persons
 	{

     	$persons = new Persons();

    	$persons->loadFromQuery("CALL sp_contacts_list()");

    	return $persons;

    }
    
    public function getByPerson(Person $person):Contacts
    {
    
         $this->loadFromQuery("CALL sp_contactsfromperson_list(?)",array(
               $person->getidperson()
               
        ));

         return $this;

    }

    public static function listFromPerson(Person $person):Contacts
    
    {

    	$contacts = new Contacts();

    	$contacts->loadFromQuery("CALL sp_contactsfromperson_list(?)", array(
    		$person->getidperson()
    	));

    	return $contacts;

    }

}

?>