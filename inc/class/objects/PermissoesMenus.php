<?php

class PermissoesMenus extends Collection {

    protected $class = "PermissaoMenu";
    protected $saveQuery = "CALL sp_permissoesmenu_save();";
    protected $saveArgs = array();
    protected $pk = "";

    public function get(){}

}

?>