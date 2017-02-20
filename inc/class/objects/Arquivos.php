<?php

class Arquivos extends Collection {

    protected $class = "Arquivo";
    protected $saveQuery = "sp_arquivos_save";
    protected $saveArgs = array("idarquivo", "desdiretorio", "desarquivo", "desextensao", "desnome");
    protected $pk = "idarquivo";

    public function get(){}

     public static function listAll():Arquivos
    {

    	$arquivo = new Arquivos();

    	$arquivo->loadFromQuery("select * from tb_arquivos");

    	return $arquivo;

    }

}

?>