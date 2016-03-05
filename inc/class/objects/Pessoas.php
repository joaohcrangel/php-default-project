<?php

class Pessoas extends Collection {

    protected $class = "Pessoa";
    protected $saveQuery = "CALL sp_pessoa_save(?, ?, ?);";
    protected $saveArgs = array("idpessoa", "despessoa", "idpessoatipo");
    protected $pk = "idpessoa";

    public function get(){}

}
?>