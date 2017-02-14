<?php

class Configuracoes extends Collection {

    protected $class = "Configuracao";
    protected $saveQuery = "sp_configuracoes_save";
    protected $saveArgs = array("idconfiguracao", "desconfiguracao", "desvalor", "idconfiguracaotipo");
    protected $pk = "idconfiguracao";

    public function get(){}

}

?>