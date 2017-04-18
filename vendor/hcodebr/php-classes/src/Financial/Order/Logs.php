<?php

namespace Hcode\Financial\Order;

use Hcode\Collection;

class Logs extends Collection {

    protected $class = "Hcode\Financial\Order\Log";
    protected $saveQuery = "sp_orderslogs_save";
    protected $saveArgs = array("idlog", "idorder", "iduser");
    protected $pk = "idlog";

    public function get(){}

    public static function listAll():Logs
    {

    	$logs = new Logs();

    	$logs->loadFromQuery("CALL sp_orderslogs_list();");

    	return $logs;

    }

}

?>