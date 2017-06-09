<?php

namespace Hcode\Stand;

use Hcode\Collection;

class ProjectsStandsTypes extends Collection {

    protected $class = "ProjectStandType";
    protected $saveQuery = "sp_projectsstandstypes_save";
    protected $saveArgs = array("idstandtype", "desstandtype", "dtregister");
    protected $pk = "idstandtype";

    public function get(){}

}

?>