<?php

class OrdersProducts extends Collection {

    protected $class = "OrderProduct";
    protected $saveQuery = "sp_ordersproducts_save";
    protected $saveArgs = array("idorder", "idproduct", "nrqtd", "vlprice", "vltotal");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll(){

    	$orders = new OrdersProducts();

    	$orders->loadFromQuery("CALL sp_ordersproducts_list();");

    	return $orders;

    }

}

?>