<?php

class Configuracoes extends Collection {

    protected $class = "Configuracao";
    protected $saveQuery = "sp_configuracoes_save";
    protected $saveArgs = array("idconfiguracao", "desconfiguracao", "desvalor", "idconfiguracaotipo");
    protected $pk = "idconfiguracao";

    public function get(){}

    public static function listAll():Configuracoes
    {

    	$configs = new Configuracoes();

    	$configs->loadFromQuery("CALL sp_configuracoes_list()");

    	return $configs;

    }

    public function getNames()
    {

    	$names = array();

    	foreach ($this->getItens() as $item) {
    		
    		$names[$item->getdesconfiguracao()] = $item->getValue();

    	}

    	return $names;

    }

    public function getByName($name)
    {

    	foreach ($this->getItens() as $item) {
    		
    		if ($item->getdesconfiguracao() === $name) {

    			return $item->getValue();
    			
    			break;

    		}

    	}

    }

}

?>