<?php

class HistoricosTipos extends Collection {

    protected $class = "HistoricoTipo";
    protected $saveQuery = "sp_historicostipos_save";
    protected $saveArgs = array("idhistoricotipo", "deshistorico");
    protected $pk = "idhistoricotipo";

    public function get(){}

     

}

?>