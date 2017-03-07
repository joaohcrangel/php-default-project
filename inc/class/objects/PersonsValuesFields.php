


<?php

class PersonsValuesFields extends Collection {

    protected $class = "PersonValueField";
    protected $saveQuery = "sp_personsvaluesfields_save";
    protected $saveArgs = array("idfield", "desfield", "dtregister");
    protected $pk = "idfield";

    public function get(){}

}

?>