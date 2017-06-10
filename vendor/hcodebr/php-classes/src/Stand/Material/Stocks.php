<?php

namespace Hcode\Stand\Material;

use Hcode\Collection;

class Stocks extends Collection {

    protected $class = "Hcode\Stand\Material\Stock";
    protected $saveQuery = "sp_materialsstocks_save";
    protected $saveArgs = array("idstock", "idmaterial", "dteliminated", "dtregister");
    protected $pk = "idstock";

    public function get(){}

}

?>