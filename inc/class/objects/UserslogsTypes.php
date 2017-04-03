<?php

class UserslogsTypes extends Collection {

    protected $class = "UserslogType";
    protected $saveQuery = "sp_userslogstypes_save";
    protected $saveArgs = array("idlogtype", "deslogtype", "dtregister");
    protected $pk = "idlogtype";

    public function get(){}

}

?>