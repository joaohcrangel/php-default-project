<?php

namespace Hcode\Shop;

use Hcode\Model;
use Hcode\Session;
use Hcode\Exception;
use Hcode\Shop\Products;
use Hcode\Shop\Coupons;
use Hcode\Shop\Cart\Freights;
use Hcode\Financial\Order;

class Cart extends Model {

    public $required = array('dessession');
    protected $pk = "idcart";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carts_get(".$args[0].");");
                
    }

    public function save():int
    {
        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carts_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcart(),
                $this->getidperson(),
                $this->getdessession(),
                $this->getinclosed(),
                $this->getnrproducts(),
                $this->getvltotal(),
                $this->getvltotalgross()
            ));

            return $this->getidcart();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_carts_remove", array(
            $this->getidcart()
        ));

        return true;
        
    }

    public function getProducts():Products
    {
        return new Products($this);
    }

    public function addProduct(Product $product)
    {

        $this->proc("sp_cartsproducts_save", [
            $this->getidcart(),
            $product->getidproduct()
        ]);

    }

    public function removeProduct(Product $product)
    {

        $this->getSql()->query("
            UPDATE tb_cartsproducts
            SET dtremoved = NOW()
            WHERE idcart = ? AND idproduct = ?
        ", [
            $this->getidcart(),
            $product->getidproduct()
        ]);

    }

    public function getCoupons():Coupons
    {
        return new Coupons($this);
    }

    public function getFreights():Freights
    {
        return new Freights($this);
    }

    public static function factory()
    {

        session_regenerate_id();

        $cart = new Cart([
            "dessession"=>session_id(),
            "idcart"=>0
        ]);

        $user = Session::getUser();

        if ($user->isLogged()) {
            $person = Session::getPerson();

            if ($person->getidperson() > 0) {
                $cart->setidperson($person->getidperson());
            }
        }

        $cart->save();

        return $cart;

    }

}

?>