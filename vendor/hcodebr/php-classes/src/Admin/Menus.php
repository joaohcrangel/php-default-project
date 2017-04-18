<?php

namespace Hcode\Admin;

use Hcode\Collection;
use Hcode\Exception;

class Menus extends Collection {

    protected $class = "Hcode\Admin\Menu";
    protected $saveQuery = "sp_menus_save";
    protected $saveArgs = array("idmenu", "idmenufather", "desmenu", "desicon", "deshref", "nrorder", "nrsubmenus");
    protected $pk = "idmenu";

    public function get(){}

    public static function listAll():Menus
    {

    	$menus = new Menus();

    	$menus->loadFromQuery("CALL sp_menus_list()");

    	return $menus;

    }

}

?>