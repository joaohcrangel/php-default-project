<?php

class CarrinhosProdutos extends Collection {

    protected $class = "CarrinhoProduto";
    protected $saveQuery = "sp_carrinhosprodutos_save";
    protected $saveArgs = array("idcarrinho", "idproduto", "inremovido", "dtremovido");
    protected $pk = "idcarrinho";
    public function get(){}

    public static function listAll(){

    	$carrinhos = new CarrinhosProdutos();

    	$carrinhos->loadFromQuery("CALL sp_carrinhosprodutos_list();");

    	return $carrinhos;

    }

}

?>