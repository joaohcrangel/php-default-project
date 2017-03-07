<?php

class ConfiguracoesTipos extends Collection {

    protected $class = "ConfiguracaoTipo";
    protected $saveQuery = "sp_configuracoestipos_save";
    protected $saveArgs = array("idconfiguracaotipo", "desconfiguracaotipo");
    protected $pk = "idconfiguracaotipo";

    public function get(){}

     public static function listAll(){
      $col = new  ConfiguracoesTipos();
      $col->loadFromQuery("call sp_configuracoestipos_list()");
      return $col;

    }

}

?>