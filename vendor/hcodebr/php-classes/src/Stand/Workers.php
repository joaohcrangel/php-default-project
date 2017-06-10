<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Workers extends Collection {

    protected $class = "Hcode\Stand\Worker";
    protected $saveQuery = "sp_workersroles_save";
    protected $saveArgs = array("idrole", "desrole", "inadmin", "dtregister");
    protected $pk = "idrole";

    public function get(){}

}

?>