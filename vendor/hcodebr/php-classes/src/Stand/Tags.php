<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Tags extends Collection {

    protected $class = "Hcode\Stand\Tag";
    protected $saveQuery = "sp_tags_save";
    protected $saveArgs = array("idtag", "destag", "inactive", "dtregister");
    protected $pk = "idtag";

    public function get(){}

}

?>