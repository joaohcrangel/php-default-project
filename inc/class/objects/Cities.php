


<?php

class Cities extends Collection {

    protected $class = "City";
    protected $saveQuery = "sp_cities_save";
    protected $saveArgs = array("idcity", "descity", "idstate", "dtregister");
    protected $pk = "idcity";

    public function get(){}

}

?>