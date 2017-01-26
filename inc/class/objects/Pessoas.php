<?php

class Pessoas extends Collection {

    protected $class = "Pessoa";
    protected $saveQuery = "CALL sp_pessoa_save(?, ?, ?);";
    protected $saveArgs = array("idpessoa", "despessoa", "idpessoatipo");
    protected $pk = "idpessoa";

    public function get(){}

    public static function listAll(){

    	$pessoas = new Pessoas();

    	$pessoas->loadFromQuery("CALL sp_pessoas_list();");

    	return $pessoas;

    }

}
?>