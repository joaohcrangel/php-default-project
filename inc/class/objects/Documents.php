


<?php

class Documents extends Collection {

    protected $class = "Document";
    protected $saveQuery = "sp_documents_save";
    protected $saveArgs = array("iddocument", "iddocumenttype", "idperson", "desdocument", "dtregister");
    protected $pk = "iddocument";

    public function get(){}

}

?>