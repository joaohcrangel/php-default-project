<?php

namespace Hcode\Team;

use Hcode\Collection;

class Workers extends Collection {

    protected $class = "Hcode\Team\Worker";
    protected $saveQuery = "sp_workers_save";
    protected $saveArgs = array("idworker", "idperson", "idjobposition", "idphoto");
    protected $pk = "idworker";

    public function get(){}

    public static function listAll():Workers
    {

    	$workers = new Workers();

    	$workers->loadFromQuery("CALL sp_workers_list();");

    	return $workers;

    }

}

?>