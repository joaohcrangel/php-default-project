<?php

class Menus extends Collection {

    protected $class = "Menu";
    protected $saveQuery = "CALL sp_menu_save(?, ?, ?, ?, ?);";
    protected $saveArgs = array("idmenupai", "idmenu", "desicone", "deshref", "nrordem");
    protected $pk = "idmenu";

    public function get(){}

    public static function listAll(){

    	$menus = new Menus();

    	$menus->loadFromQuery("CALL sp_menus_list()");

    	return $menus;

    }

}

?>