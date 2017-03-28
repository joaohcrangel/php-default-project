<?php

class ProdutosTipos extends Collection {

    protected $class = "ProdutoTipo";
    protected $saveQuery = "sp_produtotipo_save";
    protected $saveArgs = array("idprodutotipo", "desprodutotipo");
    protected $pk = "idprodutotipo";

    public function get(){}

    public static function listAll(){

    	$tipos = new ProdutosTipos();

    	$tipos->loadFromQuery("CALL sp_produtostipos_list();");

    	return $tipos;

    }

}

?>