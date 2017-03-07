<?php

class Enderecos extends Collection {

    protected $class = "Endereco";
    protected $saveQuery = "sp_enderecos_save";
    protected $saveArgs = array("idendereco", "idenderecotipo", "desendereco", "desnumero", "desbairro", "descidade", "desestado", "despais", "descep", "descomplemento", "inprincipal");
    protected $pk = "idendereco";

    public function get(){}

     public static function listAll(){

     	$enderecos = new Enderecos();

    	$enderecos->loadFromQuery("CALL sp_enderecos_list()");

    	return $enderecos;

     }

    public static function listFromPessoa(Pessoa $idpessoa):Enderecos
    {

    	$enderecos = new Enderecos();

    	$enderecos->loadFromQuery("CALL sp_enderecosfrompessoa_list(?);", array(
    		(int)$idpessoa
    	));

    	return $enderecos;

    }

    public function getByPessoa(Pessoa $pessoa):Enderecos
    {

        $this->loadFromQuery("CALL sp_enderecosfrompessoa_list(?);", array(
            $pessoa->getidpessoa()
        ));

        return $this;

    }

    public function getByLugar(Lugar $lugar):Enderecos
    {

        $this->loadFromQuery("CALL sp_enderecosfromlugar_list(?);", array(
            $lugar->getidlugar()
        ));

        return $this;

    }

}

?>