


<?php

class States extends Collection {

    protected $class = "State";
    protected $saveQuery = "sp_states_save";
    protected $saveArgs = array("idstate", "desstate", "desuf", "idcountry", "dtregister");
    protected $pk = "idstate";

    public function get(){}

}

?>