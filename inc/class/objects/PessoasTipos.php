<?php

class PessoasTipos extends Collection {

    protected $class = "PessoaTipo";
    protected $saveQuery = "sp_pessoastipos_save";
    protected $saveArgs = array("idpessoatipo", "despessoatipo");
    protected $pk = "idpessoatipo";

    public function get(){}

    public static function listAll(){

		$pessoatipo = new PessoasTipos();

		$pessoatipo->loadFromQuery("select * from tb_pessoastipos");

    	return $pessoatipo;

    }

}

?>