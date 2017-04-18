<?php

namespace Hcode\Person\Category;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Person\Category\Type";
    protected $saveQuery = "sp_personscategoriestypes_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():Hcode\Person\Category\Types
    {

    	$types = new Hcode\Person\Category\Types();

    	$types->loadFromQuery("CALL sp_personscategoriestypes_list();");

    	return $types;

    }

}

?>