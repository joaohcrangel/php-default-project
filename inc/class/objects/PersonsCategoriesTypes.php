


<?php

class PersonsCategoriesTypes extends Collection {

    protected $class = "PersonCategoryType";
    protected $saveQuery = "sp_personscategoriestypes_save";
    protected $saveArgs = array("idcategory", "descategory");
    protected $pk = "idcategory";

    public function get(){}

}

?>