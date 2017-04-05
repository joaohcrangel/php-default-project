<?php

namespace Hcode;

class Products extends Collection {

    protected $class = "Product";
    protected $saveQuery = "sp_products_save";
    protected $saveArgs = array("idproduct", "idproducttype", "desproduct", "inremoved");
    protected $pk = "idproduct";

    public function get(){}

    public static function listAll():Products
    {

    	$products = new Products();

    	$products->loadFromQuery("CALL sp_products_list();");

    	return $products;

    }

    public function getByCart(Cart $cart):Products
    {

        $this->loadFromQuery("CALL sp_productsfromcart_list(?);", array(
            $cart->getidcart()
        ));

        return $this;

    }

}

?>