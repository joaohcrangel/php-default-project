<?php

namespace Hcode;

class EmailsBlacklists extends Collection {

    protected $class = "Hcode\EmailBlacklist";
    protected $saveQuery = "sp_emailsblacklists_save";
    protected $saveArgs = array("idblacklist", "idcontact", "dtregister");
    protected $pk = "idblacklist";

    public function get(){}

}

?>