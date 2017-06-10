<?php

namespace Hcode\Stand\Material;
 
 use Hcode\Model;
 use Hcode\Exception;

class Propertie extends Model {

    public $required = array('desproperty');
    protected $pk = "idproperty";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_materialsproperties_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialsproperties_save(?, ?, ?);", array(
                $this->getidproperty(),
                $this->getdesproperty(),
                $this->getdtregister()
            ));

            return $this->getidproperty();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialsproperties_remove", array(
            $this->getidproperty()
        ));

        return true;
        
    }

}

?>