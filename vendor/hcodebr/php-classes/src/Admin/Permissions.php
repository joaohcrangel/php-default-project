<?php

namespace Hcode\Admin;

use Hcode\Collection;
use Hcode\Admin\Menu;
use Hcode\Exception;

class Permissions extends Collection {

    protected $class = "Hcode\Admin\Permission";
    protected $saveQuery = "sp_permissions_save";
    protected $saveArgs = array("idpermission", "despermission");
    protected $pk = "idpermission";

    public function get(){}

    public static function listFromMenu(Menu $menu, $missing = false):Permissions
    {

    	$permissions = new Permissions();

        $query = ($missing === false)?"CALL sp_permissionsfrommenus_list(?)":"CALL sp_permissionsfrommenusmissing_list(?)";

    	$permissions->loadFromQuery($query, array(
    		$menu->getidmenu()    		
    	));

    	return $permissions;

    }

    public static function listAll():Permissions
    {

        $permissions = new Permissions();

        $permissions->loadFromQuery("CALL sp_permissions_list()");

        return $permissions;

    }

}

?>