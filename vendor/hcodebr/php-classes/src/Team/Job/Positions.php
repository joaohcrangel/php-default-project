<?php

namespace Hcode\Team\Job;

use Hcode\Collection;

class Positions extends Collection {

    protected $class = "Hcode\Team\Job\Position";
    protected $saveQuery = "sp_jobspositions_save";
    protected $saveArgs = array("idjobposition", "desjobposition");
    protected $pk = "idjobposition";

    public function get(){}

    public static function listAll():Positions
    {

    	$positions = new Positions();

    	$positions->loadFromQuery("CALL sp_jobspositions_list()");

    	return $positions;

    }

}

?>