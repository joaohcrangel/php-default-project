<?php

class DocumentosTipos extends Collection {

    protected $class = "DocumentoTipo";
    protected $saveQuery = "sp_documentostipos_save";
    protected $saveArgs = array("iddocumentotipo", "desdocumentotipo");
    protected $pk = "iddocumentotipo";

    public function get(){}

}

?>