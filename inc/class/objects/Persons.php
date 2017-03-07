


<?php

class Persons extends Collection {

    protected $class = "Person";
    protected $saveQuery = "sp_persons_save";
    protected $saveArgs = array("idperson", "idpersontype", "desperson", "inremoved", "dtregister");
    protected $pk = "idperson";

    public function get(){}

}

?>