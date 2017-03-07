<?php

class Cart extends Model {

    public $required = array('idcart', 'idperson', 'dessession');
    protected $pk = "idcart";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carts_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carts_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcart(),
                $this->getidperson(),
                $this->getdessession(),
                $this->getinclosed(),
                $this->getnrproducts(),
                $this->getvltotal(),
                $this->getvltotalgross(),
            ));

            return $this->getidcart();

        }else{

            return false;

        }
        
    }

    public function remove()
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

     public function getFreights():CartsFreights
    {Freights
        return new CartsFreights($this);
    }


}

?>