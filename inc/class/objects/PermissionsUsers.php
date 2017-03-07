


<?php

class PermissionsUsers extends Collection {

    protected $class = "PermissionUser";
    protected $saveQuery = "sp_permissionsusers_save";
    protected $saveArgs = array("idpermission", "iduser", "dtregister");
    protected $pk = array(idpermission, iduser);

    public function get(){}

}

?>