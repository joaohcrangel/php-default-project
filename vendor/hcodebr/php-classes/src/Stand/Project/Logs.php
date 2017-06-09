<?php

namespace Hcode\Stand\Project;

use Hcode\Collection;


class Logs extends Collection {

    protected $class = "Hcode\Stand\Project\Log";
    protected $saveQuery = "sp_projectslogs_save";
    protected $saveArgs = array("idlog", "idproject", "idstatus", "dtregister");
    protected $pk = "idlog";

    public function get(){}

}

?>