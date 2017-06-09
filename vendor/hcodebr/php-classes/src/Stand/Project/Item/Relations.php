<?php

namespace Hcode\Stand\Project\Item;

use Hcode\Collection;

class Relations extends Collection {

    protected $class = "Hcode\Stand\Project\Item\Relation";
    protected $saveQuery = "sp_projectsitemsrelations_save";
    protected $saveArgs = array("idproject", "iditem", "vlqtd", "desobs", "dtregister");
    protected $pk = array('idproject', 'iditem');

    public function get(){}

}

?>