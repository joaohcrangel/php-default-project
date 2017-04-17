<?php

namespace Hcode\Financial\Order;

use Hcode\Model;
use Hcode\Exception;

class Status extends Model {

    public $required = array('desstatus');
    protected $pk = "idstatus";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_ordersstatus_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_ordersstatus_save(?, ?);", array(
                $this->getidstatus(),
                $this->getdesstatus()
            ));

            return $this->getidstatus();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("CALL sp_ordersstatus_remove(".$this->getidstatus().")");

        return true;
        
    }

}

?>