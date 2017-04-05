<?php

namespace Hcode;

class UsersLogs extends Collection {

    protected $class = "Hcode\UserLog";
    protected $saveQuery = "sp_userslogs_save";
    protected $saveArgs = array("idlog", "iduser", "idlogtype", "deslog", "desip", "dessession", "desuseragent", "despath", "dtregister");
    protected $pk = "idlog";

    public function get(){}

}

?>