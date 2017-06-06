<?php

namespace Hcode\Site;

use Hcode\Collection;

class Categories extends Collection {

    protected $class = "Hcode\Site\Category";
    protected $saveQuery = "sp_categories_save";
    protected $saveArgs = array("idcategory", "idcategoryfather", "descategory");
    protected $pk = "idcategory";

    public function get(){}

    public static function listAll():Categories
    {

    	$categories = new Categories();

    	$categories->loadFromQuery("CALL sp_categories_list();");

    	return $categories;

    }

}

?>