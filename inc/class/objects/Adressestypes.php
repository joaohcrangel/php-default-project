


<?php

class Adressestypes extends Collection {

    protected $class = "AdressType";
    protected $saveQuery = "sp_adressestypes_save";
    protected $saveArgs = array("idadresstype", "desadresstype", "dtregister");
    protected $pk = "idadresstype";

    public function get(){}

}

?>