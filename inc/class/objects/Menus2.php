


<?php

class Menus extends Collection {

    protected $class = "Menu";
    protected $saveQuery = "sp_menus_save";
    protected $saveArgs = array("idmenu", "idmenufather", "desmenu", "desicon", "deshref", "nrorder", "nrsubmenus", "dtregister");
    protected $pk = "idmenu";

    public function get(){}

}

?>