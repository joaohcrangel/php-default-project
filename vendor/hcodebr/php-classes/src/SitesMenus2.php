<?php

namespace Hcode;

class SitesMenus extends Collection {

    protected $class = "Hcode\SiteMenu";
    protected $saveQuery = "sp_sitesmenus_save";
    protected $saveArgs = array("idmenu", "idmenufather", "desmenu", "desicon", "deshref", "nrorder");
    protected $pk = "idmenu";

    public function get(){}

    public static function listAll():SitesMenus
    {

    	$menus = new SitesMenus();

    	$menus->loadFromQuery("CALL sp_sitesmenus_list()");

    	return $menus;

    }

}

?>