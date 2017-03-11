<?php

class Settings extends Collection {

    protected $class = "Setting";
    protected $saveQuery = "sp_settings_save";
    protected $saveArgs = array("idsetting", "dessetting", "desvalue", "desdescription", "idsettingtype");
    protected $pk = "idsetting";

    public function get(){}

    public static function listAll():Settings
    {

    	$configs = new Settings();

    	$configs->loadFromQuery("CALL sp_settings_list()");

    	return $configs;

    }

    public function getNames()
    {

    	$names = array();

    	foreach ($this->getItens() as $item) {
    		
    		$names[$item->getdessetting()] = $item->getValue();

    	}

    	return $names;

    }

    public function getByName($name)
    {

    	foreach ($this->getItens() as $item) {
    		
    		if ($item->getdessetting() === $name) {

    			return $item->getValue();
    			
    			break;

    		}

    	}

    }

}

?>