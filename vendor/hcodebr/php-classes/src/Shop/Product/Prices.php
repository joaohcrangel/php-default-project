<?php

namespace Hcode\Shop\Product;

use Hcode\Collection;

class Prices extends Collection {

    protected $class = "Hcode\Shop\Product\Price";
    protected $saveQuery = "sp_productsprices_save";
    protected $saveArgs = array("idprice", "idproduct", "dtstart", "dtend", "vlprice");
    protected $pk = "idprice";

    public function get(){}

}

?>