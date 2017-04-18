<?php

namespace Hcode\Address;

use Hcode\Collection;

class States extends Collection {

    protected $class = "Hcode\Address\State";
    protected $saveQuery = "sp_states_save";
    protected $saveArgs = array("idstate", "desstate", "desuf", "idcountry");
    protected $pk = "idstate";

    public function get(){}

    public static function listAll():States
    {

    	$states = new States();

    	$states->loadFromQuery("CALL sp_states_list();");

    	return $states;

    }

}

?>