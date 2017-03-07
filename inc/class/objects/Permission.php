


<?php

class Permission extends Model {

    public $required = array('idpermission', 'despermission');
    protected $pk = "idpermission";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_permissions_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissions_save(?, ?, ?);", array(
                $this->getidpermission(),
                $this->getdespermission(),
                $this->getdtregister()
            ));

            return $this->getidpermission();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_permissions_remove", array(
            $this->getidpermission()
        ));

        return true;
        
    }

}

?>