<?php

class CartoesCreditos extends Collection {

    protected $class = "CartaoCredito";
    protected $saveQuery = "sp_cartoesdecreditos_save";
    protected $saveArgs = array("idcartao", "idpessoa", "desnome", "dtvalidade", "nrcds", "desnumero");
    protected $pk = "idcartao";
    public function get(){}

    public static function listAll(){

    	$cartoes = new CartoesCreditos();

    	$cartoes->loadFromQuery("CALL sp_cartoesdecreditos_list();");

    	return $cartoes;

    }

}

?>