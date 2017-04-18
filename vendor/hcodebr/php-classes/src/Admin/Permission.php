<?php

namespace Hcode\Admin;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Session;

class Permission extends Model {

    public $required = array('despermission');
    protected $pk = "idpermission";

    const SUPER = 1;
    const ADMIN = 2;
    const CLIENT = 3;

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_permissions_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissions_save(?, ?);", array(
                $this->getidpermission(),
                $this->getdespermission()
            ));

            return $this->getidpermission();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_permissions_remove", array(
            $this->getidpermission()
        ));

        return true;
        
    }

    public static function checkSession($idpermission, $redirect = false){

        $user = Session::getUser();

        if (!$user->isLogged() || !$user->hasPermission(new Permission(array("idpermission"=>(int)$idpermission)))) {

            switch($idpermission) {
                case Permission::SUPER:
                case Permission::ADMIN:
                $url = SITE_PATH."/admin/login";
                break;

                case UserType::CLIENTE:
                $url = SITE_PATH."/login";
                break;
            }

            if ($redirect === false) {
                throw new Exception("Acesso negado.", 403);
            } else {
                header("Location: {$url}");    
            }
            
            exit;

        }

    }

}

?>