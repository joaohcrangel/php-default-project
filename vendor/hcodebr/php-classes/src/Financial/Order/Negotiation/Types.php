<?php

namespace Hcode\Financial\Order\Negotiation;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\Financial\Order\Negotiation\Type";
    protected $saveQuery = "sp_ordersnegotiationstypes_save";
    protected $saveArgs = array("idnegotiation", "desnegotiation");
    protected $pk = "idnegotiation";

    public function get(){}

    public static function listAll():Types
    {

    	$order = new Types();

    	$order->loadFromQuery("CALL sp_ordersnegotiationstypes_list();");

    	return $order;

    }

}

?>