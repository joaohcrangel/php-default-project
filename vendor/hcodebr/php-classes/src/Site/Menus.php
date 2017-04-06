<?php

namespace Hcode\Site;

use \Hcode\Collection;

class Menus extends Collection {

    protected $class = "Hcode\Site\Menu";
    protected $saveQuery = "sp_sitesmenus_save";
    protected $saveArgs = array("idmenu", "idmenufather", "desmenu", "desicon", "deshref", "nrorder");
    protected $pk = "idmenu";

    public function get(){}

    public static function listAll(){

    	$menus = new Menus();

    	$menus->loadFromQuery("CALL sp_sitesmenus_list()");

    	return $menus;

    }

}

?>