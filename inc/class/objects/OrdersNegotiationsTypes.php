<?php

class OrdersNegotiationsTypes extends Collection {

    protected $class = "OrderNegotiationType";
    protected $saveQuery = "sp_ordersnegotiationstypes_save";
    protected $saveArgs = array("idnegotiation", "desnegotiation");
    protected $pk = "idnegotiation";

    public function get(){}

      public static function listAll():OrdersNegotiationsTypes
    {

    	$order = new OrdersNegotiationsTypes();

    	$order->loadFromQuery("CALL sp_ordersnegotiationstypes_list();");

    	return $order;

    }

}

?>