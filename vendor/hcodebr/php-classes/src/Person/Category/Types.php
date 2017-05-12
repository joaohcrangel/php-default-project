<?php

namespace Hcode\Person\Category;

use Hcode\Collection;
use Hcode\Person\Person;

class Types extends Collection {

    protected $class = "Hcode\Person\Category\Type";
    protected $saveQuery = "sp_personscategoriestypes_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():Types
    {

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_personscategoriestypes_list();");

    	return $types;

    }

    public function getByHcode_Person_Person(Person $person):Types
    {

        $this->loadFromQuery("CALL sp_categoriesfromperson_list(?);", array(
            $person->getidperson()
        ));

        return $this;

    }

}

?>