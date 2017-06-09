<?php

namespace Hcode\Stand\Project;

use Hcode\Collection;

class Formats extends Collection {

    protected $class = "Hcode\Stand\Project\Format";
    protected $saveQuery = "sp_projectsformats_save";
    protected $saveArgs = array("idformat", "desformat", "dtregister");
    protected $pk = "idformat";

    public function get(){}

}

?>