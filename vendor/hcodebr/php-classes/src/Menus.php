<?php

class Menus extends Collection {

    protected $class = "Menu";
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