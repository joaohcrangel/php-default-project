<?php

namespace Hcode\System;

use Hcode\Collection;

class Configurations extends Collection {

    protected $class = "Hcode\System\Configuration";
    protected $saveQuery = "sp_configurations_save";
    protected $saveArgs = array("idconfiguration", "desconfiguration", "desvalue", "desdescription", "idconfigurationtype");
    protected $pk = "idconfiguration";

    public function get(){}

    public static function listAll():Configurations
    {

    	$configs = new Configurations();

    	$configs->loadFromQuery("CALL sp_configurations_list()");

    	return $configs;

    }

    public function getNames()
    {

    	$names = array();

    	foreach ($this->getItens() as $item) {
    		
    		$names[$item->getdesconfiguration()] = $item->getdesvalue();

    	}

    	return $names;

    }

    public function getByName($name)
    {

    	foreach ($this->getItens() as $item) {
    		
    		if ($item->getdesconfiguration() === $name) {

    			return $item->getValue();
    			
    			break;

    		}

    	}

    }

}

?>