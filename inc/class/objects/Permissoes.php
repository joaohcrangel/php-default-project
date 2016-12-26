<?php

class Permissoes extends Collection {

    protected $class = "Permissao";
    protected $saveQuery = "CALL sp_permissoes_save(?, ?);";
    protected $saveArgs = array('idpermissao', 'despermissao');
    protected $pk = "idpermissao";

    public function get(){}

}

?>