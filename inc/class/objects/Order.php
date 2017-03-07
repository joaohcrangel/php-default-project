<?php

class Order extends Model {

    public $required = array('idorder', 'idperson', 'idordermethod', 'idstatus', 'dessession', 'vltotal', 'nrparcels');
    protected $pk = "idorder";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_orders_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_orders_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidorder(),
                $this->getidperson(),
                $this->getidordermethod(),
                $this->getidstatus(),
                $this->getdessession(),
                $this->getvltotal(),
                $this->getnrparcels()
            ));

            return $this->getidorder();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("CALL sp_orders_remove(".$this->getidorder().")");

        return true;
        
    }

    public function getReceipts(){

        $receipts = new Orders();

        $receipts->loadFromQuery("CALL sp_receiptsfromorder_list(?);", array(
            $this->getidorder()
        ));

        return $receipts;

    }

}

?>