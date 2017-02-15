<?php

class SitesMenus extends Collection {

    protected $class = "SiteMenu";
    protected $saveQuery = "sp_sitesmenus_save";
    protected $saveArgs = array("idmenu", "idmenupai", "desmenu", "desicone", "deshref", "nrordem");
    protected $pk = "idmenu";

    public function get(){}

    public static function listAll(){

    	$menus = new SitesMenus();

    	$menus->loadFromQuery("CALL sp_sitesmenus_list()");

    	return $menus;

    }

}

?>