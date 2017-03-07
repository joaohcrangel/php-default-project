


<?php

class Permissions extends Collection {

    protected $class = "Permission";
    protected $saveQuery = "sp_permissions_save";
    protected $saveArgs = array("idpermission", "despermission", "dtregister");
    protected $pk = "idpermission";

    public function get(){}

}

?>