


<?php

class Countries extends Collection {

    protected $class = "Country";
    protected $saveQuery = "sp_countries_save";
    protected $saveArgs = array("idcountry", "descountry", "dtregister");
    protected $pk = "idcountry";

    public function get(){}

}

?>