<?php

class PessoasTipos extends Collection {

    protected $class = "PessoaTipo";
    protected $saveQuery = "sp_pessoastipos_save";
    protected $saveArgs = array("idpessoatipo", "despessoatipo");
    protected $pk = "idpessoatipo";

    public function get(){}

}

?>