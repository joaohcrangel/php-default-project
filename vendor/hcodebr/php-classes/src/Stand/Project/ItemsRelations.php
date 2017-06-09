<?php

namespace Hcode\Stand;

use Hcode\Collection;

class ProjectsItemsRelations extends Collection {

    protected $class = "ProjectItemRelation";
    protected $saveQuery = "sp_projectsitemsrelations_save";
    protected $saveArgs = array("idproject", "iditem", "vlqtd", "desobs", "dtregister");
    protected $pk = array(idproject, iditem);

    public function get(){}

}

?>