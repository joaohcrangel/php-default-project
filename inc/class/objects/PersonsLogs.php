


<?php

class PersonsLogs extends Collection {

    protected $class = "PersonLog";
    protected $saveQuery = "sp_personslogs_save";
    protected $saveArgs = array("idpersonlog", "idperson", "idlogtype", "deslog", "dtregister");
    protected $pk = "idpersonlog";

    public function get(){}

}

?>