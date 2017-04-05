<?php

namespace Hcode;

class OrdersLogs extends Collection {

    protected $class = "Hcode\OrderLog";
    protected $saveQuery = "sp_orderslogs_save";
    protected $saveArgs = array("idlog", "idorder", "iduser");
    protected $pk = "idlog";

    public function get(){}

    public static function listAll():OrdersLogs
    {

    	$logs = new OrdersLogs();

    	$logs->loadFromQuery("CALL sp_orderslogs_list();");

    	return $logs;

    }

}

?>