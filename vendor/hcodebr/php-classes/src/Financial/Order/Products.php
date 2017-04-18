<?php

namespace Hcode\Financial\Order;

use Hcode\Collection;

class Products extends Collection {

    protected $class = "Hcode\Financial\Order\Product";
    protected $saveQuery = "sp_ordersproducts_save";
    protected $saveArgs = array("idorder", "idproduct", "nrqtd", "vlprice", "vltotal");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll():Products
    {

    	$orders = new Products();

    	$orders->loadFromQuery("CALL sp_ordersproducts_list();");

    	return $orders;

    }

}

?>