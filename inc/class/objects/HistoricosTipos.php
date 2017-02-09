<?php

class HistoricosTipos extends Collection {

    protected $class = "HistoricoTipo";
    protected $saveQuery = "sp_historicostipos_save";
    protected $saveArgs = array("idhistoricotipo", "deshistorico");
    protected $pk = "idhistoricotipo";

    public function get(){}

      public static function listAll(){

		$historicotipo = new HistoricosTipos();

		$historicotipo->loadFromQuery("select * from tb_historicostipos");

    	return $historicotipo;

    }

}

?>