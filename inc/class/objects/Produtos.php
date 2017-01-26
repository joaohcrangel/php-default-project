<?php

class Produtos extends Collection {

    protected $class = "Produto";
    protected $saveQuery = "CALL sp_produto_save(?, ?, ?, ?);";
    protected $saveArgs = array("idproduto", "idprodutotipo", "desproduto", "vlpreco");
    protected $pk = "idproduto";

    public function get(){}

    public static function listAll(){

    	$produtos = new Produtos();

    	$produtos->loadFromQuery("CALL sp_produtos_list();");

    	return $produtos;

    }

}
?>