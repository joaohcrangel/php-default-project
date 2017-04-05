<?php

class DocumentsTypes extends Collection {

    protected $class = "DocumentType";
    protected $saveQuery = "sp_documentstypes_save";
    protected $saveArgs = array("iddocumenttype", "desdocumenttype", "dtregister");
    protected $pk = "iddocumenttype";

    public function get(){}

}

?>