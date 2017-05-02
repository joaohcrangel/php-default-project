<?php

namespace Hcode\Social;

use Hcode\Collection;

class Networks extends Collection {

    protected $class = "Hcode\Social\Network";
    protected $saveQuery = "sp_socialnetworks_save";
    protected $saveArgs = array("idsocialnetwork", "dessocialnetwork");
    protected $pk = "idsocialnetwork";

    public function get(){}

    public static function listAll():Networks
    {

    	$networks = new Networks();

    	$networks->loadFromQuery("CALL sp_socialnetworks_list()");

    	return $networks;

    }

}

?>