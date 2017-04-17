<?php

namespace Hcode\Financial\Order\Negotiation;

use Hcode\Model;
use Hcode\Exception;

class Type extends Model {

    public $required = array('desnegotiation');
    protected $pk = "idnegotiation";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_ordersnegotiationstypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_ordersnegotiationstypes_save(?, ?);", array(
                $this->getidnegotiation(),
                $this->getdesnegotiation()
            ));

            return $this->getidnegotiation();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_ordersnegotiationstypes_remove", array(
            $this->getidnegotiation()
        ));

        return true;
        
    }

}

?>