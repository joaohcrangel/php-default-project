<?php

class OrdersReceipts extends Collection {

    protected $class = "OrderReceipt";
    protected $saveQuery = "sp_ordersreceipts_save";
    protected $saveArgs = array("idorder", "desauthentication");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll(){

    	$orders = new OrdersReceipts();

    	$orders->loadFromQuery("CALL sp_ordersreceipts_list();");

    	return $orders;

    }

}

?>