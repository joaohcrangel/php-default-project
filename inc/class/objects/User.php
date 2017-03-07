


<?php

class User extends Model {

    public $required = array('iduser', 'idperson', 'desuser', 'despassword', 'inblocked', 'idusertype');
    protected $pk = "iduser";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_users_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_users_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getiduser(),
                $this->getidperson(),
                $this->getdesuser(),
                $this->getdespassword(),
                $this->getinblocked(),
                $this->getidusertype(),
                $this->getdtregister()
            ));

            return $this->getiduser();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_users_remove", array(
            $this->getiduser()
        ));

        return true;
        
    }

}

?>