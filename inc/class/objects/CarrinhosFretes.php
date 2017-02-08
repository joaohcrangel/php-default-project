<?php

class CarrinhosFretes extends Collection {

    protected $class = "CarrinhoFrete";
    protected $saveQuery = "sp_carrinhosfretes_save";
    protected $saveArgs = array("idcarrinho", "descep", "vlfrete");
    protected $pk = "idcarrinho";

    public function get(){}

    public static function listAll():CarrinhosFretes
    {

    	$fretes = new CarrinhosFretes();

    	$fretes->loadFromQuery("CALL sp_carrinhosfretes_list();");

    	return $fretes;

    }

    public function getByCarrinho(Carrinho $carrinho):CarrinhosFretes
    {

        $this->queryToAttr("CALL sp_carrinhosfretes_get(?);", array(
            $carrinho->getidcarrinho()
        ));

        return $this;

    }

}

?>