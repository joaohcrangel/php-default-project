<?php

namespace Hcode\Financial;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Financial\Orders;

class Order extends Model {

    public $required = array('idorder', 'idperson', 'idformidorder', 'idstatus', 'dessession', 'vltotal', 'nrplots');
    protected $pk = "idorder";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_orders_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_orders_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidorder(),
                $this->getidperson(),
                $this->getidformorder(),
                $this->getidstatus(),
                $this->getdessession(),
                $this->getvltotal(),
                $this->getnrplots()
            ));

            return $this->getidorder();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_orders_remove", array(
            $this->getidorder()
        ));

        return true;
        
    }

    public function getReceipts(){

        $receipts = new Orders();

        $receipts->loadFromQuery("CALL sp_receiptsfromorders_list(?);", array(
            $this->getidorder()
        ));

        return $receipts;

    }

}

?>