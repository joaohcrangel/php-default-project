


<?php

class PermissionsMenus extends Collection {

    protected $class = "PermissionMenu";
    protected $saveQuery = "sp_permissionsmenus_save";
    protected $saveArgs = array("idpermission", "idmenu", "dtregister");
    protected $pk = array(idpermission, idmenu);

    public function get(){}

}

?>