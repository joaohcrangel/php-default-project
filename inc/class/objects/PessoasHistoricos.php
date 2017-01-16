<?php

class PessoasHistoricos extends Collection {

    protected $class = "PessoaHistorico";
    protected $saveQuery = "sp_pessoashistoricos_save";
    protected $saveArgs = array("idpessoahistorico", "idpessoa", "idhistoricotipo", "deshistorico");
    protected $pk = "idpessoahistorico";

    public function get(){}

}

?>