<?php

namespace Hcode\Financial\Order;

use Hcode\Model;
use Hcode\Exception;

class Log extends Model {

    public $required = array('idlog', 'idorder', 'iduser');
    protected $pk = "idlog";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_orderslogs_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_orderslogs_save(?, ?, ?);", array(
                $this->getidlog(),
                $this->getidorder(),
                $this->getiduser()
            ));

            return $this->getidlog();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_orderslogs_remove", array(
            $this->getidlog()
        ));

        return true;
        
    }

}

?>