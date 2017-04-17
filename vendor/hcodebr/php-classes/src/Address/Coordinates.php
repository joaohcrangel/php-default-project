<?php

namespace Hcode\Address;

use Hcode\Collection;

class Coordinates extends Collection {

    protected $class = "Hcode\Address\Coordinate";
    protected $saveQuery = "sp_coordinates_save";
    protected $saveArgs = array("idcoordinate", "vllatitude", "vllongitude", "nrzoom");
    protected $pk = "idcoordinate";

    public function get(){}

}

?>