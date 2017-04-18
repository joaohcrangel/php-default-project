<?php

namespace Hcode\Shop\Coupon;

use Hcode\Collection;

class CouponsTypes extends Collection {

    protected $class = "Hcode\Shop\Coupon\Type";
    protected $saveQuery = "sp_couponstypes_save";
    protected $saveArgs = array("idcoupontype", "descoupontype", "dtregister");
    protected $pk = "idcoupontype";

    public function get(){}

     public static function listAll():Types
    {

    	$types = new Types();

    	$ypes->loadFromQuery("CALL sp_couponstypes_list();");

    	return $types;

    }

}

?>