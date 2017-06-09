<?php

namespace Hcode\Stand\Project;

use Hcode\Collection;

class Items extends Collection {

    protected $class = "Hcode\Stand\Project\Item";
    protected $saveQuery = "sp_projectsitems_save";
    protected $saveArgs = array("iditem", "desitem", "dtregister");
    protected $pk = "iditem";

    public function get(){}

}

?>