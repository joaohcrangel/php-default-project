<?php

namespace Hcode\Email;

use Hcode\Collection;

class Blacklists extends Collection {

    protected $class = "Hcode\Email\Blacklist";
    protected $saveQuery = "sp_emailsblacklists_save";
    protected $saveArgs = array("idblacklist", "idcontact", "dtregister");
    protected $pk = "idblacklist";

    public function get(){}

}

?>