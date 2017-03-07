


<?php

class Products extends Collection {

    protected $class = "Product";
    protected $saveQuery = "sp_products_save";
    protected $saveArgs = array("idproduct", "idproducttype", "desproduct", "inremoved", "dtregister");
    protected $pk = "idproduct";

    public function get(){}

}

?>