<?php

class ProductsTypes extends Collection {

    protected $class = "ProductType";
    protected $saveQuery = "sp_productstypes_save";
    protected $saveArgs = array("idproducttype", "desproducttype");
    protected $pk = "idproducttype";

    public function get(){}

    public static function listAll():ProductsTypes
    {

    	$types = new ProductsTypes();

    	$types->loadFromQuery("CALL sp_productstypes_list();");

    	return $types;

    }

}

?>