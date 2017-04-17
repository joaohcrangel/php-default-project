<?php

namespace Hcode\Shop;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Shop\Products;
use Hcode\Shop\Coupons;
use Hcode\Shop\Cart\Freights;

class Cart extends Model {

    public $required = array('idcart', 'idperson', 'dessession');
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

    public function getCoupons():Coupons
    {
        return new Coupons($this);
    }

    public function getFreights():Freights
    {
        return new Freights($this);
    }

}

?>