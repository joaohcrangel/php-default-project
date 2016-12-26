<?php

class Documentos extends Collection {

    protected $class = "Documento";
    protected $saveQuery = "sp_documentos_save";
    protected $saveArgs = array("iddocumento", "iddocumentotipo", "idpessoa", "desdocumento");
    protected $pk = "iddocumento";

    public function get(){}

}

?>