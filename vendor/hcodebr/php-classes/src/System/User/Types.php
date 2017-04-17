<?php

namespace Hcode\System\User;

use Hcode\Collection;

class Types extends Collection {

    protected $class = "Hcode\System\User\Type";
    protected $saveQuery = "sp_userstypes_save";
    protected $saveArgs = array("idusertype", "desusertype");
    protected $pk = "idusertype";

    public function get(){}

    public static function listAll():Types
    {

    	$types = new Types();

		$types->loadFromQuery("CALL sp_userstypes_list()");

		return $types;

    }

}

?>