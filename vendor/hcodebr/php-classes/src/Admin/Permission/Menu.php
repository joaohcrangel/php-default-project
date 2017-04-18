<?php

namespace Hcode\Admin\Permission;

use Hcode\Model;
use Hcode\Exception;

class Menu extends Model {

    public $required = array('idpermission', 'idmenu');
    protected $pk = "";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
        if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
        $this->queryToAttr("CALL sp_permissionsmenus_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissionsmenus_save(?, ?);", array(
                $this->getidpermission(),
                $this->getidmenu()
            ));

            return $this->getidpermission();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_permissionsmenus_remove", array(
            $this->getidpermission()
        ));

        return true;
        
    }

}

?>