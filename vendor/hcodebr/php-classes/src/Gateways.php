<?php

namespace Hcode;

class Gateways extends Collection {

    protected $class = "Hcode\Gateway";
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