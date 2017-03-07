


<?php

class ProductsTypes extends Collection {

    protected $class = "ProductType";
    protected $saveQuery = "sp_productstypes_save";
    protected $saveArgs = array("idproducttype", "desproducttype", "dtregister");
    protected $pk = "idproducttype";

    public function get(){}

}

?>