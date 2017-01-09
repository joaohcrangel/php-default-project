<?php

class Gateways extends Collection {

    protected $class = "Gateway";
    protected $saveQuery = "sp_gateways_save";
    protected $saveArgs = array("idgateway", "desgateway");
    protected $pk = "idgateway";
    public function get(){}

    public static function listAll(){

    	$gateways = new Gateways();

    	$gateways->loadFromQuery("CALL sp_gateways_list();");

    	return $gateways;

    }

}

?>