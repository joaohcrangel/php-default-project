<?php

namespace Hcode\Shop\Cart;

use Hcode\Collection;
use Hcode\Shop\Cart;

class Freights extends Collection {

    protected $class = "Hcode\Shop\Cart\Freight";
    protected $saveQuery = "sp_cartsfreights_save";
    protected $saveArgs = array("idcart", "deszipcode", "vlfreight");
    protected $pk = "idcart";

    public function get(){}

    public static function listAll():Freights
    {

    	$freights = new Freights();

    	$freights->loadFromQuery("CALL sp_carrinhosfretes_list();");

    	return $freights;

    }

    public function getByCart(Cart $cart):Freights
    {

        $this->queryToAttr("CALL sp_cartsfreights_get(?);", array(
            $cart->getidcart()
        ));

        return $this;

    }

}

?>