<?php

class Permissoes extends Collection {

    protected $class = "Permissao";
    protected $saveQuery = "CALL sp_permissoe_save();";
    protected $saveArgs = array();
    protected $pk = "";

    public function get(){}

}

?>