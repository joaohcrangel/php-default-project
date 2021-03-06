<?php

namespace Hcode\Stand\Material;
 
 use Hcode\Model;
 use Hcode\Exception;

class Unit extends Model {

    public $required = array('desidunitytype');
    protected $pk = "idunitytype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_materialsunitstypes_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialsunitstypes_save(?, ?, ?, ?);", array(
                $this->getidunitytype(),
                $this->getdesidunitytype(),
                $this->getdesunitytypeshort(),
                $this->getdtregister()
            ));

            return $this->getidunitytype();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialsunitstypes_remove", array(
            $this->getidunitytype()
        ));

        return true;
        
    }

}

?>