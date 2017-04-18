<?php

namespace Hcode\Admin\Permission;

use Hcode\Collection;
use Hcode\Exception;

class Menus extends Collection {

    protected $class = "Hcode\Admin\Permission\Menu";
    protected $saveQuery = "sp_permissionsmenus_save";
    protected $saveArgs = array("idpermission", "idmenu");
    protected $pk = "";

    public function get(){}

}

?>