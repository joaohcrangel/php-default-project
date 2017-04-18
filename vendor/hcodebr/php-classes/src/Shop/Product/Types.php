<?php

namespace Hcode\Shop\Product;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Shop\Product\Type";
    protected $saveQuery = "sp_productstypes_save";
    protected $saveArgs = array("idproducttype", "desproducttype");
    protected $pk = "idproducttype";

    public function get(){}

    public static function listAll():Types
    {

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_productstypes_list();");

    	return $types;

    }

}

?>