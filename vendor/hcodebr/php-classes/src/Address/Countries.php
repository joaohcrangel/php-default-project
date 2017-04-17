<?php

namespace Hcode\Address;

use Hcode\Collection;

class Countries extends Collection {

    protected $class = "Hcode\Address\Country";
    protected $saveQuery = "sp_countries_save";
    protected $saveArgs = array("idcountry", "descountry");
    protected $pk = "idcountry";

    public function get(){}

    public static function listAll():Countries
    {

    	$countries = new Countries();

    	$countries->loadFromQuery("CALL sp_countries_list();");

    	return $countries;

    }

}

?>