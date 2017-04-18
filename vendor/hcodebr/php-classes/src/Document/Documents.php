<?php

namespace Hcode\Document;

use Hcode\Collection;
use Hcode\Exception;
use Hcode\Document\Types;
use Hcode\Person\Person;

class Documents extends Collection {

    protected $class = "Hcode\Document\Document";
    protected $saveQuery = "sp_documents_save";
    protected $saveArgs = array("iddocument", "iddocumenttype", "idperson", "desdocument");
    protected $pk = "iddocument";

    public function get(){}

    public static function listTypes():Types
    {

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_documentstypes_list();");

    	return $types;

    }

    public static function listFromPerson(Person $person):Documents
    {

    	$documents = new Documents();

        $documents->getByPerson($person);

    	return $documents;

    }

    public function getByPerson(Person $person):Documents
    {
    
        $this->loadFromQuery("CALL sp_documentsfromperson_list(?)",array(
            $person->getidperson()
        ));

         return $this;

    }

}

?>