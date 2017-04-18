<?php

namespace Hcode\Shop;

use Hcode\Collection;
use Hcode\Shop\Cart;

class Coupons extends Collection {

    protected $class = "Hcode\Shop\Coupon";
    protected $saveQuery = "sp_coupons_save";
    protected $saveArgs = array("idcoupon", "idcoupontype", "descoupon", "descode", "nrqtd", "nrqtdused", "dtstart", "dtend", "inremoved", "nrdiscount");
    protected $pk = "idcoupon";

    public function get(){}

    public static function listAll():Coupons
    {

    	$coupons = new Coupons();

    	$coupons->loadFromQuery("CALL sp_coupons_list();");

    	return $coupons;

    }

    public function getByCart(Cart $cart):Coupons
    {

        $this->loadFromQuery("CALL sp_couponsfromcart_list(?);", array(
            $cart->getidcart()
        ));

        return $this;

    }

}

?>