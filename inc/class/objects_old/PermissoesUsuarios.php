<?php

class PermissoesUsuarios extends Collection {

    protected $class = "PermissoesUsuario";
    protected $saveQuery = "CALL sp_permissoesusuario_save();";
    protected $saveArgs = array();
    protected $pk = "";

    public function get(){}

}

?>