
<?php

class EmailsBlacklists extends Collection {

    protected $class = "EmailBlacklist";
    protected $saveQuery = "sp_emailsblacklists_save";
    protected $saveArgs = array("idblacklist", "idcontact", "dtregister");
    protected $pk = "idblacklist";

    public function get(){}

}

?>