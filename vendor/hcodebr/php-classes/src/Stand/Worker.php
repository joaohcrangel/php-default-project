<?php

 namespace Hcode\Stand;
 
 use Hcode\Model;
 use Hcode\Exception;


class Worker extends Model {

    public $required = array('desrole', 'inadmin');
    protected $pk = "idrole";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_workersroles_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_workersroles_save(?, ?, ?, ?);", array(
                $this->getidrole(),
                $this->getdesrole(),
                $this->getinadmin(),
                $this->getdtregister()
            ));

            return $this->getidrole();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_workersroles_remove", array(
            $this->getidrole()
        ));

        return true;
        
    }

}

?>