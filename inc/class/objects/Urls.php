


<?php

class Urls extends Collection {

    protected $class = "Url";
    protected $saveQuery = "sp_urls_save";
    protected $saveArgs = array("idurl", "desurl", "destitulo");
    protected $pk = "idurl";

    public function get(){}

}

?>