<?php

namespace Hcode\System\User;

use Hcode\Collection;

class Logs extends Collection {

    protected $class = "Hcode\System\User\Log";
    protected $saveQuery = "sp_userslogs_save";
    protected $saveArgs = array("idlog", "iduser", "idlogtype", "deslog", "desip", "dessession", "desuseragent", "despath", "dtregister");
    protected $pk = "idlog";

    public function get(){}

}

?>