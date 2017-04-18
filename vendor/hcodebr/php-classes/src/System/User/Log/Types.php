<?php

namespace Hcode\System\User\Log;

class Types extends Collection {

    protected $class = "Hcode\System\User\Log\Type";
    protected $saveQuery = "sp_userslogstypes_save";
    protected $saveArgs = array("idlogtype", "deslogtype", "dtregister");
    protected $pk = "idlogtype";

    public function get(){}

    public static function listAll():Types
    {

    	$logs = new Types();

		$logs->loadFromQuery("CALL sp_userslogstypes_list()");

		return $logs;

    }

}

?>