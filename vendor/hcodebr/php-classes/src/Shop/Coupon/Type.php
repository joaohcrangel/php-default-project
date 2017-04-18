<?php

namespace Hcode\Shop\Coupon;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('idcoupontype', 'descoupontype');
    protected $pk = "idcoupontype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_couponstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_couponstypes_save(?, ?, ?);", array(
                $this->getidcoupontype(),
                $this->getdescoupontype(),
                $this->getdtregister()
            ));

            return $this->getidcoupontype();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_couponstypes_remove", array(
            $this->getidcoupontype()
        ));

        return true;
        
    }

}

?>