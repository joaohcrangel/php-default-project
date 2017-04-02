<?php

class BlogCategories extends Collection {

    protected $class = "BlogCategory";
    protected $saveQuery = "sp_blogcategories_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

}

?>