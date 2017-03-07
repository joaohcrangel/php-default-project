


<?php

class UsersTypes extends Collection {

    protected $class = "UserType";
    protected $saveQuery = "sp_userstypes_save";
    protected $saveArgs = array("idusertype", "desusertype", "dtregister");
    protected $pk = "idusertype";

    public function get(){}

}

?>