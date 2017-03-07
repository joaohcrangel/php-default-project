


<?php

class PersonsTypes extends Collection {

    protected $class = "PersonType";
    protected $saveQuery = "sp_personstypes_save";
    protected $saveArgs = array("idpersontype", "despersontype", "dtregister");
    protected $pk = "idpersontype";

    public function get(){}

}

?>