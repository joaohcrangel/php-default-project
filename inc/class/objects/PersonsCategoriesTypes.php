<?php

class PersonsCategoriesTypes extends Collection {

    protected $class = "PersonCategoryType";
    protected $saveQuery = "sp_personscategoriestypes_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():PersonsCategoriesTypes
    {

    	$types = new PersonsCategoriesTypes();

    	$types->loadFromQuery("CALL sp_personscategoriestypes_list();");

    	return $types;

    }

}

?>