<?php

class Cities extends Collection {

    protected $class = "City";
    protected $saveQuery = "sp_cities_save";
    protected $saveArgs = array("idcity", "descity", "idstate");
    protected $pk = "idcity";

    public function get(){}

    public static function listAll():Cities
    {

    	$cities = new Cities();

    	$cities->loadFromQuery("CALL sp_cities_list();");

    	return $cities;

    }

}

?>