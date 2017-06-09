<?php

namespace Hcode\Stand\Material\Stock;

use Hcode\Collection;

class Tags extends Collection {

    protected $class = "Hcode\Stand\Material\Stock\Tag";
    protected $saveQuery = "sp_materialsstockstags_save";
    protected $saveArgs = array("idstock", "idtag", "dtregister");
    protected $pk = array('idstock', 'idtag');

    public function get(){}

}

?>