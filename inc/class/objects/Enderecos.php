<?php

class Enderecos extends Collection {

    protected $class = "Endereco";
    protected $saveQuery = "sp_enderecos_save";
    protected $saveArgs = array("idendereco", "idenderecotipo", "idpessoa", "desendereco", "desnumero", "desbairro", "descidade", "desestado", "despais", "descep", "descomplemento");
    protected $pk = "idendereco";

    public function get(){}

    public static function listFromPessoa($idpessoa){

    	$enderecos = new Enderecos();

    	$enderecos->loadFromQuery("CALL sp_enderecosfrompessoa_list(?);", array(
    		(int)$idpessoa
    	));

    	return $enderecos;

    }

}

?>