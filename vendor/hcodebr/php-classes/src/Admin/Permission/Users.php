<?php

namespace Hcode\Admin\Permission;

use Hcode\Collection;
use Hcode\Exception;

class Users extends Collection {

    protected $class = "Hcode\Admin\Permission\User";
    protected $saveQuery = "sp_permissionsusers_save";
    protected $saveArgs = array("idpermission", "iduser");
    protected $pk = "";

    public function get(){}

}

?>