<?php

class UsersLogsTypes extends Collection {

    protected $class = "UserLogType";
    protected $saveQuery = "sp_userslogstypes_save";
    protected $saveArgs = array("idlogtype", "deslogtype", "dtregister");
    protected $pk = "idlogtype";

    public function get(){}

    public static function listAll():UsersLogsTypes
    {

    	$logs = new UsersLogsTypes();

		$logs->loadFromQuery("CALL sp_userslogstypes_list()");

		return $logs;

    }

}

?>