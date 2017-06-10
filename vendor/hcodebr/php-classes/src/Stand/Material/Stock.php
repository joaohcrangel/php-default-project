<?php

namespace Hcode\Stand\Material;
 
 use Hcode\Model;
 use Hcode\Exception;

class Stock extends Model {

    public $required = array('idmaterial');
    protected $pk = "idstock";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_materialsstocks_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialsstocks_save(?, ?, ?, ?);", array(
                $this->getidstock(),
                $this->getidmaterial(),
                $this->getdteliminated(),
                $this->getdtregister()
            ));

            return $this->getidstock();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialsstocks_remove", array(
            $this->getidstock()
        ));

        return true;
        
    }

}

?>