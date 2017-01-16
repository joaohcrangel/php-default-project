<?php

class Enderecos extends Collection {

    protected $class = "Endereco";
    protected $saveQuery = "sp_enderecos_save";
    protected $saveArgs = array("idendereco", "idenderecotipo", "idpessoa", "desendereco", "desnumero", "desbairro", "descidade", "desestado", "despais", "descep", "descomplemento");
    protected $pk = "idendereco";

    public function get(){}


     public static function listAll(){

     	$enderecos = new Enderecos();

    	$enderecos->loadFromQuery("call sp_enderecos_list()");

    	return $enderecos;

     }


}

?>