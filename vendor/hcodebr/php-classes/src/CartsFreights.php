<?php

namespace Hcode;

class CartsFreights extends Collection {

    protected $class = "Hcode\CartFreight";
    protected $saveQuery = "sp_cartsfreights_save";
    protected $saveArgs = array("idcart", "deszipcode", "vlfreight");
    protected $pk = "idcart";

    public function get(){}

    public static function listAll():CartsFreights
    {

    	$freights = new CartsFreights();

    	$freights->loadFromQuery("CALL sp_carrinhosfretes_list();");

    	return $freights;

    }

    public function getByCart(Cart $cart):CartsFreights
    {

        $this->queryToAttr("CALL sp_cartsfreights_get(?);", array(
            $cart->getidcart()
        ));

        return $this;

    }

}

?>