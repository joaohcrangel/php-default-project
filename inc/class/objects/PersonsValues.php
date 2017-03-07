


<?php

class PersonsValues extends Collection {

    protected $class = "PersonValue";
    protected $saveQuery = "sp_personsvalues_save";
    protected $saveArgs = array("idpersonvalue", "idperson", "idfield", "desvalue", "dtregister");
    protected $pk = "idpersonvalue";

    public function get(){}

}

?>