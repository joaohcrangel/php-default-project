<?php

namespace Hcode\Contact;

use Hcode\Collection;
use Hcode\Exception;

class Types extends Collection {

    protected $class = "Hcode\Contact\Type";
    protected $saveQuery = "sp_contactstypes_save";
    protected $saveArgs = array("idcontacttype", "descontacttype");
    protected $pk = "idcontacttype";

    public function get(){}

    public static function listAll():Types
    {

    	$types = new Types();

    	$types->loadFromQuery("CALL sp_contactstypes_list();");

    	return $types;

    }

}

?>