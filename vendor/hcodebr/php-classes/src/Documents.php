<?php

namespace Hcode;

class Documents extends Collection {

    protected $class = "Hcode\Document";
    protected $saveQuery = "sp_documents_save";
    protected $saveArgs = array("iddocument", "iddocumenttype", "idperson", "desdocument");
    protected $pk = "iddocument";

    public function get(){}

    public static function listTypes():DocumentsTypes
    {

    	$types = new DocumentsTypes();

    	$types->loadFromQuery("CALL sp_documentstypes_list();");

    	return $types;

    }

    public static function listFromPerson($idperson){

    	$documents = new Documents();

    	$documents->loadFromQuery("CALL sp_documentsfromperson_list(?)", array(
    		(int)$idperson
    	));

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