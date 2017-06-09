<?php

namespace Hcode\Stand\Event;

use Hcode\Model;
use Hcode\Exception;

class Propertie extends Model {

    public $required = array('desproperty');
    protected $pk = "idproperty";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_eventsproperties_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_eventsproperties_save(?, ?);", array(
                $this->getidproperty(),
                $this->getdesproperty()
            ));

            return $this->getidproperty();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_eventsproperties_remove", array(
            $this->getidproperty()
        ));

        return true;
        
    }

}

?>