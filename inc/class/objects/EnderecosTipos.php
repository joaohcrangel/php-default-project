<?php

class EnderecosTipos extends Collection {

    protected $class = "EnderecoTipo";
    protected $saveQuery = "sp_enderecostipos_save";
    protected $saveArgs = array("idenderecotipo", "desenderecotipo");
    protected $pk = "idenderecotipo";

    public function get(){}

}

?>