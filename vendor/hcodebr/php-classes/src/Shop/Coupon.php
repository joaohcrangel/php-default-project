<?php

namespace Hcode\Shop;

use Hcode\Model;
use Hcode\Exception;

class Coupon extends Model {

    public $required = array('idcoupon', 'idcoupontype', 'descoupon', 'descode', 'nrqtd', 'nrdiscount');
    protected $pk = "idcoupon";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_coupons_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_coupons_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcoupon(),
                $this->getidcoupontype(),
                $this->getdescoupon(),
                $this->getdescode(),
                $this->getnrqtd(),
                $this->getnrqtdused(),
                $this->getdtstart(),
                $this->getdtend(),
                $this->getinremoved(),
                $this->getnrdiscount()
            ));

            return $this->getidcoupon();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_coupons_remove", array(
            $this->getidcoupon()
        ));

        return true;
        
    }

}

?>