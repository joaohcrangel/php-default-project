<?php

namespace Hcode;

class CouponsTypes extends Collection {

    protected $class = "Hcode\CouponType";
    protected $saveQuery = "sp_couponstypes_save";
    protected $saveArgs = array("idcoupontype", "descoupontype", "dtregister");
    protected $pk = "idcoupontype";

    public function get(){}

     public static function listAll():CouponsTypes
    {

    	$types = new CouponsTypes();

    	$ypes->loadFromQuery("CALL sp_couponstypes_list();");

    	return $types;

    }

}

?>