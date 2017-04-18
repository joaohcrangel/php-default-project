<?php

namespace Hcode\Financial\Order;

use Hcode\Collection;

class Statuses extends Collection {

    protected $class = "Hcode\Financial\Order\Status";
    protected $saveQuery = "sp_ordersstatus_save";
    protected $saveArgs = array("idstatus", "desstatus");
    protected $pk = "idstatus";
    public function get(){}

    public static function listAll():Statuses
    {

    	$orders = new Statuses();

    	$orders->loadFromQuery("CALL sp_ordersstatus_list();");

    	return $orders;

    }

}

?>