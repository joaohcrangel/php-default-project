


<?php

class PersonsCategories extends Collection {

    protected $class = "PersonCategory";
    protected $saveQuery = "sp_personscategories_save";
    protected $saveArgs = array("idperson", "idcategory", "dtregister");
    protected $pk = array(idperson, idcategory);

    public function get(){}

}

?>