<?php

namespace Hcode;

class PermissionsUsers extends Collection {

    protected $class = "Hcode\PermissionUser";
    protected $saveQuery = "sp_permissionsusers_save";
    protected $saveArgs = array("idpermission", "iduser");
    protected $pk = "";

    public function get(){}

}

?>