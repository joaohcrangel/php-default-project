<?php

namespace Hcode\Financial\Order;

use Hcode\Model;
use Hcode\Exception;

class Receipt extends Model {

    public $required = array('idorder', 'desauthentication');
    protected $pk = "idorder";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_ordersreceipts_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_ordersreceipts_save(?, ?);", array(
                $this->getidorder(),
                $this->getdesauthentication()
            ));

            return $this->getidorder();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_ordersreceipts_remove", array(
            $this->getidorder()
        ));

        return true;
        
    }

}

?>