<?php

class UsersLogs extends Collection {

    protected $class = "UserLog";
    protected $saveQuery = "sp_userslogs_save";
    protected $saveArgs = array("idlog", "iduser", "idlogtype", "deslog", "desip", "dessession", "desuseragent", "despath", "dtregister");
    protected $pk = "idlog";

    public function get(){}

}

?>