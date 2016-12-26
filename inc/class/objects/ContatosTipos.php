<?php

class ContatoTipos extends Collection {

    protected $class = "ContatoTipo";
    protected $saveQuery = "sp_contatostipos_save";
    protected $saveArgs = array("idcontatotipo", "descontatotipo");
    protected $pk = "idcontatotipo";

    public function get(){}

}

?>