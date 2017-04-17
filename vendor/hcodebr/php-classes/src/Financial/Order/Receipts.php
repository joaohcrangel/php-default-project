<?php

namespace Hcode\Financial\Order;

use Hcode\Collection;

class Receipts extends Collection {

    protected $class = "Hcode\Financial\Order\Receipt";
    protected $saveQuery = "sp_ordersreceipts_save";
    protected $saveArgs = array("idorder", "desauthentication");
    protected $pk = "idorder";
    public function get(){}

    public static function listAll():Receipts
    {

    	$orders = new Receipts();

    	$orders->loadFromQuery("CALL sp_ordersreceipts_list();");

    	return $orders;

    }

}

?>