


<?php

class PermissionUser extends Model {

    public $required = array('idpermission', 'iduser');
    protected $pk = array(idpermission, iduser);

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_permissionsusers_get(".$args[0].". ".$args[1].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissionsusers_save(?, ?, ?);", array(
                $this->getidpermission(),
                $this->getiduser(),
                $this->getdtregister()
            ));

            return $this->getidpermission();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_permissionsusers_remove", array(
            $this->getidpermission()
        ));

        return true;
        
    }

}

?>