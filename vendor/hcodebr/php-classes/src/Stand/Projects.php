<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Projects extends Collection {

    protected $class = "Hcode\Stand\Project";
    protected $saveQuery = "sp_projects_save";
    protected $saveArgs = array("idproject", "desproject", "descode", "idclient", "idsalesman", "dtdue", "dtdelivery", "idcalendar", "idformat", "idstandtype", "vlsum", "desdescription", "dtregister");
    protected $pk = "idproject";

    public function get(){}

}

?>