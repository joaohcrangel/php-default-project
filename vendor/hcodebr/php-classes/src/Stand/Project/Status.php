<?php

namespace Hcode\Stand\Project;

use Hcode\Collection;

class Status extends Collection {

    protected $class = "Hcode\Stand\Project\Statu";
    protected $saveQuery = "sp_projectsstatus_save";
    protected $saveArgs = array("idstatus", "desstatus", "dtregister");
    protected $pk = "idstatus";

    public function get(){}

}

?>