


<?php

class Users extends Collection {

    protected $class = "User";
    protected $saveQuery = "sp_users_save";
    protected $saveArgs = array("iduser", "idperson", "desuser", "despassword", "inblocked", "idusertype", "dtregister");
    protected $pk = "iduser";

    public function get(){}

}

?>