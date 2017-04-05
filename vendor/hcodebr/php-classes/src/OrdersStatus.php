<?php

namespace Hcode;

class OrdersStatus extends Collection {

    protected $class = "OrderStatus";
    protected $saveQuery = "sp_ordersstatus_save";
    protected $saveArgs = array("idstatus", "desstatus");
    protected $pk = "idstatus";
    public function get(){}

    public static function listAll(){

    	$orders = new OrdersStatus();

    	$orders->loadFromQuery("CALL sp_ordersstatus_list();");

    	return $orders;

    }

}

?>