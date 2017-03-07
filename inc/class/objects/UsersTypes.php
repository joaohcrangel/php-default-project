<?php

class UsersTypes extends Collection {

    protected $class = "UserType";
    protected $saveQuery = "sp_userstypes_save";
    protected $saveArgs = array("idusertype", "desusertype");
    protected $pk = "idusertype";

    public function get(){}

    public static function listAll():UsersTypes
    {

    	$types = new UsersTypes();

		$types->loadFromQuery("CALL sp_userstypes_list()");

		return $types;

    }

}

?>