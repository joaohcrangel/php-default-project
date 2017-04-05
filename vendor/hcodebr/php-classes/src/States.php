<?php

namespace Hcode;

class States extends Collection {

    protected $class = "State";
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