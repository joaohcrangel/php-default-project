<?php

namespace Hcode\Document;

use Hcode\Collection;
use Hcode\Exception;

class Types extends Collection {

    protected $class = "Hcode\Document\Type";
    protected $saveQuery = "sp_documentstypes_save";
    protected $saveArgs = array("iddocumenttype", "desdocumenttype", "dtregister");
    protected $pk = "iddocumenttype";

    public function get(){}

}

?>