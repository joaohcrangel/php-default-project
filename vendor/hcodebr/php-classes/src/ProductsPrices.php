<?php

namespace Hcode;

class ProductsPrices extends Collection {

    protected $class = "Hcode\ProductPrice";
    protected $saveQuery = "sp_productsprices_save";
    protected $saveArgs = array("idprice", "idproduct", "dtstart", "dtend", "vlprice");
    protected $pk = "idprice";

    public function get(){}

}

?>